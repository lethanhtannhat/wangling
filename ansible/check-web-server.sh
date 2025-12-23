#!/bin/bash

url="https://corp-it.iconic-intl.com"
redirect_urls=("https://www.corp-it.iconic-intl.com" "http://corp-it.iconic-intl.com/")

response=$(curl -s -o /dev/null -w "%{http_code}" $url)

if [ $response -eq 200 ]; then
    echo "Website $url is up"
else
    echo "Website $url is down"
fi

server_header=$(curl -sI "$url" | grep -i ^Server | awk '{print $2}' | tr -d '\r')

if [[ "$server_header" == "Apache" ]]; then
  echo "✅ Server header is correct: Server: Apache"
else
  echo "⚠️ Warning: Server header is not 'Apache' — it is: Server: $server_header"
fi


for redirect_url in "${redirect_urls[@]}"; do
    response=$(curl -s -o /dev/null -w "%{http_code}" $redirect_url)

    if [ $response -eq 301 ] || [ $response -eq 302 ]; then
        redirect_location=$(curl -s -I $redirect_url | grep -i "Location:" | awk '{print $2}')
        echo "Redirect url $redirect_url is up, code: $response, redirect location: $redirect_location"
    else
        echo "Redirect url $redirect_url is down, code: $response"
    fi
done

# Print IP address of url and redirect urls
# Function to extract hostname and get IP
get_ip() {
    local full_url="$1"
    # Remove protocol (http:// or https://) and trailing slashes
    host=$(echo "$full_url" | sed -E 's~https?://~~;s~/.*~~')
    ip=$(dig +short "$host" | grep -E '^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+')
    echo "$host: ${ip:-IP not found}"
}

echo "Main URL:"
get_ip "$url"

echo -e "\nRedirect URLs:"
for rurl in "${redirect_urls[@]}"; do
    get_ip "$rurl"
done

# Make sure that MySQL port 3306 is not open to the public on the server of url from outside
# Another way: netstat -plunt | grep 3306
host=$(echo "$url" | sed -E 's_https?://([^/]+).*_\1_')
port=3306

echo "Checking if MySQL port $port is accessible from the internet on host: $host..."

# Try to connect with nc
if nc -vz -w 3 "$host" $port 2>&1 | grep -q 'succeeded'; then
    echo "⚠️ WARNING: Port $port (MySQL) is OPEN to the internet on $host!"
    echo "    ➤ This could expose your database to unauthorized access."
    echo "    ➤ Consider binding MySQL to 127.0.0.1 and using a firewall."
else
    echo "✅ SAFE: Port $port is NOT accessible from the internet on $host."
    echo "    ➤ Your MySQL service is protected from external access."
fi
