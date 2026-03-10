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
    if (!confirm('Are you sure you want to delete this user from the device?')) {
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

// Alert Listener Variables
let alertListenerInterval = null;
let isAlertListenerRunning = false;

// Start alert listener
function startAlertListener() {
    if (isAlertListenerRunning) {
        toastr.warning('Alert listener is already running');
        return;
    }

    isAlertListenerRunning = true;
    $('#alert-listener-status').html('<span class="badge badge-success">Running</span>');
    $('#start-alert-listener').prop('disabled', true);
    $('#stop-alert-listener').prop('disabled', false);
    toastr.success('Alert listener started');

    // Poll for alerts every 5 seconds
    alertListenerInterval = setInterval(function() {
        loadRecentAlerts();
    }, 5000);

    // Initial load
    loadRecentAlerts();
}

// Stop alert listener
function stopAlertListener() {
    if (!isAlertListenerRunning) {
        toastr.warning('Alert listener is not running');
        return;
    }

    isAlertListenerRunning = false;
    $('#alert-listener-status').html('<span class="badge badge-danger">Stopped</span>');
    $('#start-alert-listener').prop('disabled', false);
    $('#stop-alert-listener').prop('disabled', true);
    toastr.success('Alert listener stopped');

    // Clear interval
    if (alertListenerInterval) {
        clearInterval(alertListenerInterval);
        alertListenerInterval = null;
    }
}

// Load recent alerts
function loadRecentAlerts() {
    $.ajax({
        url: '{{ route("hikvision.getRecentAlerts") }}',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                displayAlerts(response.data);
            }
        },
        error: function(xhr) {
            console.error('Failed to load recent alerts');
        }
    });
}

// Display alerts in table
function displayAlerts(alerts) {
    let tbody = $('#alerts-table-body');
    tbody.empty();

    if (!alerts || alerts.length === 0) {
        tbody.html('<tr><td colspan="7" class="text-center">No alerts received yet</td></tr>');
        return;
    }

    alerts.forEach(function(alert) {
        const dateTime = alert.dateTime || '-';
        const eventType = alert.eventType || '-';
        const eventState = alert.eventState || '-';
        const employeeNo = alert.AccessControllerEvent?.employeeNoString || '-';
        const deviceName = alert.AccessControllerEvent?.deviceName || '-';
        const subEventType = alert.AccessControllerEvent?.subEventType || '-';
        
        // Determine event type description
        let eventDescription = 'Unknown';
        if (subEventType === 38) {
            eventDescription = 'Card Authentication';
        } else if (subEventType === 22) {
            eventDescription = 'Door Opened';
        }

        tbody.append(`
            <tr>
                <td>${dateTime}</td>
                <td>${deviceName}</td>
                <td>${employeeNo}</td>
                <td>${eventDescription}</td>
                <td><span class="badge badge-${eventState === 'active' ? 'success' : 'warning'}">${eventState}</span></td>
                <td>${eventType}</td>
                <td>
                    <button type="button" class="btn btn-info btn-sm" onclick="viewAlertDetails('${encodeURIComponent(JSON.stringify(alert))}')">
                        <i class="fas fa-eye"></i> View
                    </button>
                </td>
            </tr>
        `);
    });
}

// View alert details
function viewAlertDetails(alertJson) {
    const alert = JSON.parse(decodeURIComponent(alertJson));
    
    let html = '<div class="row">';
    html += '<div class="col-md-6">';
    html += '<table class="table table-bordered table-striped">';
    html += '<tbody>';
    
    // Basic alert info
    html += `<tr><th>Date Time</th><td>${alert.dateTime || '-'}</td></tr>`;
    html += `<tr><th>IP Address</th><td>${alert.ipAddress || '-'}</td></tr>`;
    html += `<tr><th>Port</th><td>${alert.portNo || '-'}</td></tr>`;
    html += `<tr><th>Protocol</th><td>${alert.protocol || '-'}</td></tr>`;
    html += `<tr><th>Event Type</th><td>${alert.eventType || '-'}</td></tr>`;
    html += `<tr><th>Event State</th><td>${alert.eventState || '-'}</td></tr>`;
    html += `<tr><th>Event Description</th><td>${alert.eventDescription || '-'}</td></tr>`;
    
    html += '</tbody></table>';
    html += '</div>';
    
    html += '<div class="col-md-6">';
    html += '<table class="table table-bordered table-striped">';
    html += '<tbody>';
    
    // Access Controller Event info
    if (alert.AccessControllerEvent) {
        const accessEvent = alert.AccessControllerEvent;
        html += `<tr><th>Device Name</th><td>${accessEvent.deviceName || '-'}</td></tr>`;
        html += `<tr><th>Major Event Type</th><td>${accessEvent.majorEventType || '-'}</td></tr>`;
        html += `<tr><th>Sub Event Type</th><td>${accessEvent.subEventType || '-'}</td></tr>`;
        html += `<tr><th>Employee No</th><td>${accessEvent.employeeNoString || '-'}</td></tr>`;
        html += `<tr><th>Card Type</th><td>${accessEvent.cardType || '-'}</td></tr>`;
        html += `<tr><th>Card Reader No</th><td>${accessEvent.cardReaderNo || '-'}</td></tr>`;
        html += `<tr><th>Door No</th><td>${accessEvent.doorNo || '-'}</td></tr>`;
        html += `<tr><th>Serial No</th><td>${accessEvent.serialNo || '-'}</td></tr>`;
        html += `<tr><th>User Type</th><td>${accessEvent.userType || '-'}</td></tr>`;
        html += `<tr><th>Status Value</th><td>${accessEvent.statusValue || '-'}</td></tr>`;
    }
    
    html += '</tbody></table>';
    html += '</div>';
    html += '</div>';
    
    $('#alert-details-display').html(html);
    $('#alert-details-modal').modal('show');
}

// Clear alerts
function clearAlerts() {
    if (!confirm('Are you sure you want to clear all alerts?')) {
        return;
    }

    $.ajax({
        url: '{{ route("hikvision.clearAlerts") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
                loadRecentAlerts();
            } else {
                toastr.error(response.message);
            }
        },
        error: function(xhr) {
            toastr.error('Failed to clear alerts');
        }
    });
}
