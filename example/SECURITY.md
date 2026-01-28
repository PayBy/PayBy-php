# Security Notice

## Private Key Management

**IMPORTANT:** Never commit actual private keys to version control.

### Setup Instructions

1. Generate your own private/public key pair
2. Place them in the `cert/` directory
3. These files are excluded by `.gitignore`

### Generate Keys

```bash
# Generate private key
openssl genrsa -out cert/PayBy_key_private.pem 2048

# Export public key
openssl rsa -in cert/PayBy_key_private.pem -out cert/PayBy_key_public_key.pem -pubout
```

### Best Practices

- Store private keys securely
- Use environment variables for production
- Never share private keys
- Rotate keys regularly