@extends('layouts.app')

@section('title', 'Google 2FA Management')
@section('header', 'Google 2FA Management')

@section('content')
<div class="section">
    <div class="section-header">Upload Google User Report (CSV)</div>
    <div class="section-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('google2fa.upload') }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf
            <div class="col-auto">
                <input type="file" name="csv_file" class="form-control" accept=".csv" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Upload & Sync</button>
            </div>
        </form>
        

    </div>
</div>

@if(isset($results) && count($results) > 0)
<div class="section mt-4">
    <div class="section-header">Google 2FA Status (Total: {{ count($results) }})</div>
    <div class="section-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th style="background: #f8f9fa;">Email Address</th>
                        <th style="background: #f8f9fa;" class="text-center">2sv Enrolled Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    <tr>
                        <td>{{ $result->email }}</td>
                        <td class="text-center">
                            @if($result->status == 'True')
                                <span class="badge bg-success">True</span>
                            @elseif($result->status == 'False')
                                <span class="badge bg-danger">False</span>
                            @else
                                {{ $result->status }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection
