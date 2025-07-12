# TMI Cluster for Twitch Chatbots

<p align="center">
  <img height="500" src="https://cdn.jsdelivr.net/gh/ghostzero/tmi-website@main/docs/images/tmi_cluster.png">
</p>

<p align="center">
  <a href="https://packagist.org/packages/ghostzero/tmi-cluster"><img src="https://img.shields.io/packagist/dt/ghostzero/tmi-cluster" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/ghostzero/tmi-cluster"><img src="https://img.shields.io/packagist/v/ghostzero/tmi-cluster" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/ghostzero/tmi-cluster"><img src="https://img.shields.io/packagist/l/ghostzero/tmi-cluster" alt="License"></a>
  <a href="https://ghostzero.dev/discord"><img src="https://discordapp.com/api/guilds/590942233126240261/embed.png?style=shield" alt="Discord"></a>
</p>

## Introduction

TMI Cluster enables a highly scalable IRC client cluster for Twitch. TMI Cluster consists of multiple supervisors that can be deployed on multiple hosts. The core is inspired by [Horizon](https://github.com/laravel/horizon), which handles the complex IRC process management. It is designed to work within the Laravel ecosystem.

The cluster stores its data in the database and has a Redis Command Queue to send IRC commands and receive messages.

## Features

- Supervisors can be deployed on multiple servers
- Up-to-date Twitch IRC Client written in PHP 8
- Scalable message input/output queue
- Advanced cluster status dashboard
- Channel management and invite screen

## Recent Updates (v3.5.0)

### Improved IRC Race Condition Handling

This version includes important updates from TMI v2.4.0 that fix critical race conditions:

- **Resilient to out-of-order IRC messages**: The cluster no longer crashes when receiving NameReply messages for channels that haven't been joined yet
- **Better reconnection handling**: Improved stability during network issues and reconnections
- **Orphaned message tracking**: New events allow tracking of messages received for disconnected channels

These improvements make the cluster much more stable at scale, especially when managing hundreds or thousands of channels.

## PHP Twitch Messaging Interface

The TMI Cluster is powered by the [PHP Twitch Messaging Interface](https://github.com/ghostzero/tmi) client to communicate with Twitch. It's a full featured, high performance Twitch IRC client written in PHP 8.

## Official Documentation

You can view our official documentation [here](https://tmiphp.com/docs/tmi-cluster.html).
