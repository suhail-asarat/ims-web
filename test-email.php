<?php
// Simple email test script
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Mail;

// Test basic email sending
try {
    Mail::raw('This is a test email from your IMS Book Store application.', function ($message) {
        $message->to('email.jaad@gmail.com')
               ->subject('Email Configuration Test');
    });

    echo "✅ Email sent successfully!\n";
    echo "Check your inbox at email.jaad@gmail.com\n";
} catch (Exception $e) {
    echo "❌ Email failed to send:\n";
    echo $e->getMessage() . "\n";
}
