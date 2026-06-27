# CRSM Weekly Compliance Mail Queue

The compliance mail module creates its queue tables automatically:

- `crsm_mail_campaigns`
- `crsm_mail_queue`

Recommended cron setup:

```bash
# Build or refresh the weekly campaign queue every Monday morning.
0 7 * * 1 php C:/Ampps/www/project234/app/complianceMailCron.php queue

# Send at most 45 emails per hour, leaving a buffer below the 50/hour mail-server limit.
5 * * * * php C:/Ampps/www/project234/app/complianceMailCron.php send 45
```

Manual commands:

```bash
php C:/Ampps/www/project234/app/complianceMailCron.php queue
php C:/Ampps/www/project234/app/complianceMailCron.php send 45
php C:/Ampps/www/project234/app/complianceMailCron.php weekly 45
```

Set `CRSM_PORTAL_URL` in the server environment to the public portal root so open tracking works:

```bash
CRSM_PORTAL_URL=https://your-portal-domain.example
```

Delivery tracking notes:

- `sent` means the SMTP server accepted the message.
- `failed` means PHPMailer/SMTP returned an error after retries.
- `opened` means the recipient loaded the tracking image. Some email clients block remote images, so open tracking is useful but not absolute proof of reading.
