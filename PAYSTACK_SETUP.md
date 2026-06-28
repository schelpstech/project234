# Paystack Online Payment Setup

The portal now supports two invoice payment paths:

- bank transfer/deposit receipt upload
- Paystack online payment with server-side verification

Configure these environment variables on the web server:

```bash
PAYSTACK_SECRET_KEY=sk_live_xxxxxxxxxxxxxxxxxxxxx
CRSM_PORTAL_URL=https://your-portal-domain.example
```

Optional:

```bash
PAYSTACK_CALLBACK_URL=https://your-portal-domain.example/app/paystackCallback.php
```

Operational notes:

- Paystack amounts are sent in kobo, so a portal invoice of `1000` is initialized as `100000`.
- Online payment only starts for validated invoices.
- Successful Paystack verification marks the invoice as paid and records a matching portal transaction.
- Receipt upload remains available for bank transfer/deposit payments and still requires admin confirmation.
- The Paystack secret key must not be committed into the repository.
