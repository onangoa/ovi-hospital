@extends('layouts.layout')

@section('one_page_css')
    <link href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3>@lang('Hikvision Settings')</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">@lang('Dashboard')</a>
                    </li>
                    <li class="breadcrumb-item">@lang('Settings')</li>
                    <li class="breadcrumb-item active">@lang('Hikvision')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

@if(isset($error))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> @lang('Error!')</h5>
        {{ $error }}
    </div>
@endif

<div class="card">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-device-tab" data-toggle="tab" href="#nav-device" role="tab" aria-controls="nav-device" aria-selected="true">@lang('Device Info & Status')</a>
            <a class="nav-item nav-link" id="nav-users-tab" data-toggle="tab" href="#nav-users" role="tab" aria-controls="nav-users" aria-selected="false">@lang('Users')</a>
            <a class="nav-item nav-link" id="nav-alerts-tab" data-toggle="tab" href="#nav-alerts" role="tab" aria-controls="nav-alerts" aria-selected="false">@lang('Alert Listener')</a>
        </div>
    </nav>
    <div class="card-body custom-padding-top-0">
        <section id="tabs" class="project-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content" id="nav-tabContent">
                        <!-- Device Info & Status Tab -->
                        <div class="tab-pane fade show active" id="nav-device" role="tabpanel" aria-labelledby="nav-device-tab">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-info card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">@lang('Device Status')</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="info-box bg-{{ $isOnline ? 'success' : 'danger' }}">
                                                            <span class="info-box-icon"><i class="fas fa-server"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-text">@lang('Connection Status')</span>
                                                                <span class="info-box-number">{{ $isOnline ? __('Online') : __('Offline') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="info-box bg-info">
                                                            <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-text">@lang('Total Users')</span>
                                                                <span class="info-box-number">{{ $personCount }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-info card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">@lang('Device Actions')</h3>
                                            </div>
                                            <div class="card-body">
                                                <button type="button" class="btn btn-info btn-lg btn-block" onclick="refreshDeviceInfo()">
                                                    <i class="fas fa-sync-alt"></i> @lang('Refresh Device Info')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($deviceInfo)
                                <div class="card card-info card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">@lang('Device Information')</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>@lang('Device Name')</th>
                                                    <td>{{ $deviceInfo['deviceName'] ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>@lang('Device ID')</th>
                                                    <td>{{ $deviceInfo['deviceID'] ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>@lang('Serial Number')</th>
                                                    <td>{{ $deviceInfo['serialNumber'] ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>@lang('MAC Address')</th>
                                                    <td>{{ $deviceInfo['macAddress'] ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>@lang('Firmware Version')</th>
                                                    <td>{{ $deviceInfo['firmwareVersion'] ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>@lang('Hardware Version')</th>
                                                    <td>{{ $deviceInfo['hardwareVersion'] ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>@lang('Model')</th>
                                                    <td>{{ $deviceInfo['model'] ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>@lang('Manufacturer')</th>
                                                    <td>{{ $deviceInfo['manufacturer'] ?? '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif

                                @if($deviceStatus)
                                <div class="card card-success card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">@lang('System Status')</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>@lang('Uptime')</th>
                                                    <td>{{ $deviceStatus['uptime'] ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>@lang('CPU Usage')</th>
                                                    <td>{{ $deviceStatus['cpuUsage'] ?? '-' }}%</td>
                                                </tr>
                                                <tr>
                                                    <th>@lang('Memory Usage')</th>
                                                    <td>{{ $deviceStatus['memoryUsage'] ?? '-' }}%</td>
                                                </tr>
                                                <tr>
                                                    <th>@lang('Disk Usage')</th>
                                                    <td>{{ $deviceStatus['diskUsage'] ?? '-' }}%</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif

                                @if($deviceCapabilities)
                                <div class="card card-warning card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">@lang('Device Capabilities')</h3>
                                    </div>
                                    <div class="card-body">
                                        <pre>{{ json_encode($deviceCapabilities, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Users Tab -->
                        <div class="tab-pane fade" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-info card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">@lang('Add User to Device')</h3>
                                            </div>
                                            <div class="card-body">
                                                <form id="add-user-form">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="user_id">@lang('Select User') <b class="ambitious-crimson">*</b></label>
                                                        <select id="user_id" name="user_id" class="form-control select2" required>
                                                            <option value="">@lang('-- Select User --')</option>
                                                            @foreach($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-success btn-lg">
                                                        <i class="fas fa-user-plus"></i> @lang('Add User to Device')
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-warning card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">@lang('Device Users')</h3>
                                            </div>
                                            <div class="card-body">
                                                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="loadDeviceUsers()">
                                                    <i class="fas fa-sync"></i> @lang('Load Device Users')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-success card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">@lang('Device Users List')</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="device-users-table">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('Employee No')</th>
                                                        <th>@lang('Name')</th>
                                                        <th>@lang('User Type')</th>
                                                        <th>@lang('Valid')</th>
                                                        <th>@lang('Email')</th>
                                                        <th>@lang('Phone')</th>
                                                        <th>@lang('Actions')</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="device-users-table-body">
                                                    <tr>
                                                        <td colspan="7" class="text-center">@lang('Click Load Device Users to view')</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alert Listener Tab -->
                        <div class="tab-pane fade" id="nav-alerts" role="tabpanel" aria-labelledby="nav-alerts-tab">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-info card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">@lang('Alert Listener Control')</h3>
                                                <div class="card-tools">
                                                    <span id="alert-listener-status">
                                                        <span class="badge badge-danger">Stopped</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <button type="button" id="start-alert-listener" class="btn btn-success btn-lg btn-block" onclick="startAlertListener()">
                                                            <i class="fas fa-play"></i> @lang('Start Alert Listener')
                                                        </button>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="button" id="stop-alert-listener" class="btn btn-danger btn-lg btn-block" onclick="stopAlertListener()" disabled>
                                                            <i class="fas fa-stop"></i> @lang('Stop Alert Listener')
                                                        </button>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="loadRecentAlerts()">
                                                            <i class="fas fa-sync"></i> @lang('Refresh Alerts')
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="alert alert-info mt-3">
                                                    <i class="fas fa-info-circle"></i> @lang('The alert listener will continuously poll the Hikvision device for access control events. When a user authenticates, the system will capture the employee ID from the event.')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-success card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">@lang('Recent Access Control Alerts')</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-sm btn-danger" onclick="clearAlerts()">
                                                <i class="fas fa-trash"></i> @lang('Clear Alerts')
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="alerts-table">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('Date Time')</th>
                                                        <th>@lang('Device')</th>
                                                        <th>@lang('Employee No')</th>
                                                        <th>@lang('Event Type')</th>
                                                        <th>@lang('Status')</th>
                                                        <th>@lang('Event Category')</th>
                                                        <th>@lang('Actions')</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="alerts-table-body">
                                                    <tr>
                                                        <td colspan="7" class="text-center">@lang('Start the alert listener to receive events')</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Alert Details Modal -->
<div class="modal fade" id="alert-details-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Alert Details')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert-details-display">
                    <p class="text-muted">@lang('No alert details available')</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer')
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2();

    // Show/hide authentication credentials based on auth type
    $('#http_auth_type').on('change', function() {
        if ($(this).val() !== 'none') {
            $('#auth-credentials').show();
        } else {
            $('#auth-credentials').hide();
        }
    });

    // Add user form submission
    $('#add-user-form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("hikvision.addUser") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    $('#add-user-form')[0].reset();
                    loadDeviceUsers();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + '\n';
                });
                toastr.error(errorMessage);
            }
        });
    });

    // Notification form submission
    $('#notification-form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("hikvision.configureNotification") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    $('#notification-form')[0].reset();
                    loadNotificationHosts();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + '\n';
                });
                toastr.error(errorMessage);
            }
        });
    });
});

// Refresh device info
function refreshDeviceInfo() {
    $.ajax({
        url: '{{ route("hikvision.getDeviceInfo") }}',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                toastr.success('Device info refreshed successfully');
                location.reload();
            } else {
                toastr.error(response.message);
            }
        },
        error: function(xhr) {
            toastr.error('Failed to refresh device info');
        }
    });
}

// Load device users
function loadDeviceUsers() {
    $.ajax({
        url: '{{ route("hikvision.getDeviceUsers") }}',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                displayDeviceUsers(response.data);
                toastr.success('Device users loaded successfully');
            } else {
                toastr.error(response.message);
            }
        },
        error: function(xhr) {
            toastr.error('Failed to load device users');
        }
    });
}

// Display device users in table
function displayDeviceUsers(users) {
    let tbody = $('#device-users-table-body');
    tbody.empty();

    if (!users || users.length === 0) {
        tbody.html('<tr><td colspan="7" class="text-center">No users found on device</td></tr>');
        return;
    }

    users.forEach(function(user) {
        const validEnabled = user.validEnabled ? 'Yes' : 'No';
        const validClass = user.validEnabled ? 'text-success' : 'text-danger';

        tbody.append(`
            <tr>
                <td>${user.employeeNo}</td>
                <td>${user.name}</td>
                <td>${user.userType}</td>
                <td class="${validClass}">${validEnabled}</td>
                <td>${user.email || '-'}</td>
                <td>${user.phoneNumber || '-'}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteUser('${user.employeeNo}')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </td>
            </tr>
        `);
    });
}

// Delete user from device
function deleteUser(employeeNo) {
    if (!confirm('Are you sure you want to delete this user from device?')) {
        return;
    }

    $.ajax({
        url: '{{ route("hikvision.deleteUser") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            employee_no: employeeNo
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
                loadDeviceUsers();
            } else {
                toastr.error(response.message);
            }
        },
        error: function(xhr) {
            toastr.error('Failed to delete user from device');
        }
    });
}

// Load notification hosts
function loadNotificationHosts() {
    $.ajax({
        url: '{{ route("hikvision.getNotificationHosts") }}',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                displayNotificationHosts(response.data);
                toastr.success('Notification hosts loaded successfully');
            } else {
                toastr.error(response.message);
            }
        },
        error: function(xhr) {
            toastr.error('Failed to load notification hosts');
        }
    });
}

// Display notification hosts in table
function displayNotificationHosts(data) {
    let tbody = $('#notification-hosts-table-body');
    tbody.empty();

    if (!data || !data.HttpHostList || !data.HttpHostList.HttpHostNotification) {
        tbody.html('<tr><td colspan="6" class="text-center">No notification hosts configured</td></tr>');
        return;
    }

    const hosts = Array.isArray(data.HttpHostList.HttpHostNotification)
        ? data.HttpHostList.HttpHostNotification
        : [data.HttpHostList.HttpHostNotification];

    hosts.forEach(function(host) {
        const enabled = host.enabled ? 'Yes' : 'No';
        const enabledClass = host.enabled ? 'text-success' : 'text-danger';

        tbody.append(`
            <tr>
                <td>${host.id}</td>
                <td>${host.ipAddress || host.hostName || '-'}</td>
                <td>${host.protocolType}</td>
                <td>${host.portNo}</td>
                <td class="${enabledClass}">${enabled}</td>
                <td>
                    <button type="button" class="btn btn-info btn-sm" onclick="testNotification(${host.id})">
                        <i class="fas fa-vial"></i> Test
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteNotificationHost(${host.id})">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </td>
            </tr>
        `);
    });
}

// Delete notification host
function deleteNotificationHost(hostId) {
    if (!confirm('Are you sure you want to delete this notification host?')) {
        return;
    }

    $.ajax({
        url: '{{ route("hikvision.deleteNotificationHost") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            host_id: hostId
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
                loadNotificationHosts();
            } else {
                toastr.error(response.message);
            }
        },
        error: function(xhr) {
            toastr.error('Failed to delete notification host');
        }
    });
}

// Test notification
function testNotification(hostId) {
    $.ajax({
        url: '{{ route("hikvision.testNotification") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            host_id: hostId
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }
        },
        error: function(xhr) {
            toastr.error('Failed to test notification');
        }
    });
}
</script>
@endpush
