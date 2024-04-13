<p align="center">
    <a href="https://8lines.io">
        <img alt="8lines" src="https://8lines-static.s3.eu-central-1.amazonaws.com/open-source-logo-main.png">
    </a>
</p>

# SyliusNotificationPlugin
Slack Notification Channel Adapter

---

### Table of Content
- [Overview](#overview)
- [Installation](#installation)
- [Usage](#usage)

### Overview
This package is an adapter for the [SyliusNotificationPlugin](https://github.com/8lines/SyliusNotificationsPlugin) that allows you to send notifications to [Slack](https://slack.com).

### Installation
To install the adapter you need to run the following command:
```bash
composer require 8lines/sylius-notification-plugin-slack-adapter
```
Then configure [Slack Notifier](https://github.com/symfony/slack-notifier) and add the following variable to your `.env` file:
```dotenv
SLACK_DSN=slack://TOKEN@default?channel=CHANNEL
```
And finally, add the following configuration to your `config/packages/notifier.yaml` file:
```yaml
framework:
  notifier:
    chatter_transports:
      slack: '%env(SLACK_DSN)%'
```

### Usage
After the installation, you can use the **Slack Notification Channel** in your application. 
There are one additional option that you can specify during the notification creation:
- `recipient` - the channel to which the notification will be sent. It can be either a channel name or a channel ID. If not specified, the notification will be sent to the default channel.
