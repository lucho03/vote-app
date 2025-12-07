document.addEventListener("DOMContentLoaded", function () {
    const endpoints = document.getElementById('page-data').dataset;

    async function hashSha512(value) {
        const encoder = new TextEncoder();
        const data = encoder.encode(value);

        const hashBuffer = await crypto.subtle.digest("SHA-512", data);
        const hashArray = Array.from(new Uint8Array(hashBuffer));
        const hashHex = hashArray.map(b => b.toString(16).padStart(2, "0")).join("");
        return hashHex;
    }

    function arrayBufferToBase64(buffer) {
        const bytes = new Uint8Array(buffer);
        let binary = '';

        for (let i=0; i < bytes.byteLength; i++) {
            binary += String.fromCharCode(bytes[i]);
        }
        return btoa(binary);
    }

    function randomSalt() {
        const bytes = new Uint8Array(16);
        crypto.getRandomValues(bytes);
        return bytes;
    }

    // -------------------------------
    // AES-GCM encrypt function
    // Returns { cipherBase64, ivBase64 }
    // -------------------------------

    async function encryptPayload(plaintext, keyHex) {
        const key = await crypto.subtle.importKey(
            'raw',
            keyHex,
            { name: 'AES-GCM' },
            false,
            ['encrypt']
        );
        const iv = crypto.getRandomValues(new Uint8Array(12));
        const data = new TextEncoder().encode(plaintext);

        const cipherBuffer = await crypto.subtle.encrypt(
            { name: 'AES-GCM', iv: iv, tagLength: 128 },
            key,
            data
        );

        return {
            cipherBase64: arrayBufferToBase64(cipherBuffer),
            ivBase64: arrayBufferToBase64(iv.buffer)
        };
    }

    async function deriveKey(password, saltBytes) {
        const keyMaterial = await crypto.subtle.importKey(
            "raw",
            new TextEncoder().encode(password),
            "PBKDF2",
            false,
            ["deriveBits"]
        );

        const derivedBits = await crypto.subtle.deriveBits(
            {
                name: "PBKDF2",
                hash: "SHA-256",
                salt: saltBytes,
                iterations: 200000
            },
            keyMaterial,
            256
        );

        return new Uint8Array(derivedBits);
    }

    async function encryptAndSubmit() {
        const formData = new FormData(document.getElementById('voteForm'));
        const party = formData.get('party');
        const candidate = formData.get('candidate');
        const voterId = document.getElementById('voterId').value;
        const voterSecretKey = document.getElementById('voterSecretKey').value;

        if (!party) {
            alert('Please select a party!');
            return;
        }

        if(!candidate) {
            alert('Please select a candidate!');
            return;
        }

        if(!voterId) {
            alert('Please insert your ID!');
            return;
        }

        if(!voterSecretKey) {
            alert('Please insert your secret key!');
            return;
        }
        
        const payloadObj = {
            party: party,
            candidate: candidate,
            voter_id: voterId,
            timestamp: new Date().toISOString()
        };
        const plaintext = JSON.stringify(payloadObj);

        const hashedVoterID = await hashSha512(voterId);

        try {
            const salt = randomSalt();
            const key = await deriveKey(voterSecretKey, salt);
            const { cipherBase64, ivBase64 } = await encryptPayload(plaintext, key);

            axios.post(endpoints.submitEndpoint, {
                cipher: cipherBase64,
                iv: ivBase64,
                salt: btoa(String.fromCharCode(...salt)),
                voterID: hashedVoterID
            })
            .then(response => {
                if(response.status !== undefined && response.status == 200) {
                    alert( response.data.message );

                    setTimeout(() => {
                        window.location.replace(endpoints.redirectEndpoint);
                    }, 270);
                }
                console.log(response);
            })
            .catch(error => {
                console.error('Error submitting vote:', error);
            });

        } catch (err) {
            console.error(err);
        }
    }

    document.getElementById('sendEncryptedData').addEventListener('click', encryptAndSubmit);
});