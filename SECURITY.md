# Security Policy 🛡️

## Supported Versions

Currently, only the latest `main` branch is supported with security updates.

| Version | Supported          |
| ------- | ------------------ |
| v0.1.x  | ✅ Yes            |
| < v0.1  | ❌ No             |

## Reporting a Vulnerability

**DO NOT open a public issue for security vulnerabilities.**

If you discover a security-related issue, please send an email to the maintainer (check GitHub profile) or use the private reporting feature in the GitHub "Security" tab.

We will acknowledge your report within 48 hours and provide a timeline for a fix.

## Best Practices for Users

1. **Protect /KT/**: Ensure the `KT/` directory is not publicly writable.
2. **Dashboard Security**: Always change the default `uninstall_password` in `KT/kaiju-config.php`.
3. **API Keys**: Use environment variables or restricted config files for API keys.
