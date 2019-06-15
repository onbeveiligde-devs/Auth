# Endpoints
## Get
/api/key
```
Get all keys as a array of filenames
```

/api/key/index/`<key name>`
__or__ /api/key/public/`<key name>`
```
Get public key
```

## Post
/api/data/ 
```
Upload an array of files
```

/api/signature/ 
```
Upload an array of signatures
```

/api/key/ 
```
Upload an array of keys
```

### openssl
/api/key/decrypt
```
decrypt data with public key
```
```json
{
    "key": "<key name>",
    "data": "<data filename>"
}
```

/api/key/encript
```
encript data with public key
```
```json
{
    "key": "<key name>",
    "data": "<data filename>"
}
```

/api/key/Verify
```
Verify Digital Signature
```
```json
{
    "key": "<key name>",
    "data": "<data filename>"
}
```