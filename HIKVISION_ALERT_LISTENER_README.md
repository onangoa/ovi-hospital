# Hikvision Alert Listener System

## Overview

The Hikvision Alert Listener System replaces the previous notification system with a real-time alert monitoring solution that captures access control events from Hikvision devices. The system continuously polls the Hikvision device's alert stream endpoint and displays authentication events, including user IDs (employee numbers).

## Features

- **Real-time Alert Monitoring**: Continuously listens to Hikvision device for access control events
- **User Authentication Tracking**: Captures employee IDs when users authenticate via card, fingerprint, or other methods
- **Event Type Detection**: Identifies different event types (card authentication, door opened, etc.)
- **Alert History**: Maintains a cache of the last 100 alerts
- **Detailed Event Information**: Displays comprehensive event details including device name, timestamp, and user information

## Architecture

### Backend Components

1. **HikvisionController** (`app/Http/Controllers/HikvisionController.php`)
   - `getAlertStream()`: Fetches alerts from the Hikvision device
   - `parseAlertStream()`: Parses the multipart JSON response
   - `getRecentAlerts()`: Returns cached alerts
   - `storeAlert()`: Stores incoming alerts from webhooks
   - `clearAlerts()`: Clears all cached alerts

2. **ListenToHikvisionAlerts Command** (`app/Console/Commands/ListenToHikvisionAlerts.php`)
   - Background command that continuously polls the Hikvision device
   - Parses alerts and stores them in cache
   - Runs indefinitely until stopped

3. **Routes** (`routes/web.php`)
   - `/hikvision/alert-stream`: GET endpoint to fetch alerts
   - `/hikvision/alert-listener`: GET endpoint for long polling
   - `/hikvision/recent-alerts`: GET endpoint to retrieve cached alerts
   - `/hikvision/store-alert`: POST endpoint to store alerts
   - `/hikvision/clear-alerts`: POST endpoint to clear alerts

### Frontend Components

1. **Hikvision Settings View** (`resources/views/settings/hikvision/index.blade.php`)
   - Alert Listener tab with start/stop controls
   - Real-time alert display table
   - Alert details modal

2. **Hikvision JavaScript** (`public/assets/js/hikvision.js`)
   - `startAlertListener()`: Starts polling for alerts
   - `stopAlertListener()`: Stops polling
   - `loadRecentAlerts()`: Fetches and displays alerts
   - `displayAlerts()`: Renders alerts in the table
   - `viewAlertDetails()`: Shows detailed alert information
   - `clearAlerts()`: Clears all alerts

## Installation & Setup

### 1. Configure Hikvision Device

Update your `.env` file with your Hikvision device credentials:

```env
HIKVISION_IP=10.247.20.195
HIKVISION_PORT=80
HIKVISION_USERNAME=admin
HIKVISION_PASSWORD=JDR2Bovi
HIKVISION_PROTOCOL=http
HIKVISION_TIMEOUT=30
HIKVISION_VERIFY_SSL=false
```

### 2. Start the Alert Listener

Run the background command to start listening for alerts:

```bash
php artisan hikvision:listen-alerts
```

For production, you may want to run this as a service or use a process manager like Supervisor:

**Supervisor Configuration Example** (`/etc/supervisor/conf.d/hikvision-alerts.conf`):

```ini
[program:hikvision-alerts]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan hikvision:listen-alerts
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/hikvision-alerts.log
```

### 3. Access the Alert Listener UI

Navigate to the Hikvision settings page in your application:

```
http://your-domain.com/hikvision
```

Click on the "Alert Listener" tab to:
- Start/stop the alert listener
- View real-time alerts
- View detailed alert information
- Clear alert history

## Alert Data Format

The system captures alerts in the following format:

```json
{
    "ipAddress": "192.0.0.64",
    "portNo": 80,
    "protocol": "HTTP",
    "dateTime": "2026-03-02T06:47:59+03:00",
    "activePostCount": 1,
    "eventType": "AccessControllerEvent",
    "eventState": "active",
    "eventDescription": "Access Controller Event",
    "AccessControllerEvent": {
        "deviceName": "DS-K1T904AMF",
        "majorEventType": 5,
        "subEventType": 38,
        "cardType": 1,
        "cardReaderNo": 1,
        "doorNo": 1,
        "employeeNoString": "2",
        "serialNo": 325,
        "userType": "normal",
        "attendanceStatus": "undefined",
        "statusValue": 0,
        "picturesNumber": 0,
        "purePwdVerifyEnable": true
    }
}
```

### Key Fields

- **employeeNoString**: The user ID that authenticated
- **subEventType**: Type of event (38 = Card Authentication, 22 = Door Opened, etc.)
- **serialNo**: Unique identifier for the event
- **deviceName**: Name of the Hikvision device
- **dateTime**: Timestamp of the event

## Event Types

| Sub Event Type | Description |
|---------------|-------------|
| 22 | Door Opened |
| 38 | Card Authentication |
| 39 | Fingerprint Authentication |
| 40 | Face Authentication |
| 41 | Password Authentication |

## API Endpoints

### GET /hikvision/alert-stream
Fetches alerts directly from the Hikvision device.

**Response:**
```json
{
    "success": true,
    "data": [/* array of alerts */]
}
```

### GET /hikvision/recent-alerts
Retrieves cached alerts (last 100).

**Response:**
```json
{
    "success": true,
    "data": [/* array of alerts */]
}
```

### POST /hikvision/store-alert
Stores an incoming alert (for webhook integration).

**Request Body:** Alert JSON object

**Response:**
```json
{
    "success": true,
    "message": "Alert stored successfully"
}
```

### POST /hikvision/clear-alerts
Clears all cached alerts.

**Response:**
```json
{
    "success": true,
    "message": "Alerts cleared successfully"
}
```

## Troubleshooting

### Alerts not appearing

1. **Check device connectivity**: Ensure the Hikvision device is accessible from your server
2. **Verify credentials**: Confirm username and password are correct in `.env`
3. **Check logs**: Review `storage/logs/laravel.log` for errors
4. **Test endpoint**: Try accessing `http://[IP]/ISAPI/Event/notification/alertStream` directly

### Alert listener not starting

1. **Check command**: Ensure `php artisan hikvision:listen-alerts` runs without errors
2. **Verify configuration**: Check `config/hikvision.php` settings
3. **Check permissions**: Ensure the application has write permissions for cache

### Duplicate alerts

The system automatically deduplicates alerts based on the `serialNo` field. If you see duplicates, check that the cache is functioning correctly.

## Security Considerations

- The alert stream uses digest authentication
- Credentials are stored in environment variables
- SSL verification can be disabled for development but should be enabled in production
- Consider implementing rate limiting for the alert endpoints

## Performance

- Alerts are cached for 24 hours
- Maximum of 100 alerts are stored in memory
- Polling interval is 5 seconds (configurable in the command)
- The listener uses minimal CPU and memory resources

## Future Enhancements

- WebSocket support for real-time updates without polling
- Database storage for alert history
- Alert filtering and search functionality
- Email/SMS notifications for specific events
- Integration with user management system

## Support

For issues or questions, please check:
1. Application logs: `storage/logs/laravel.log`
2. Hikvision device logs
3. Network connectivity between server and device
