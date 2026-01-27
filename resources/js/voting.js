document.addEventListener("DOMContentLoaded", function () {
    const partyItems = document.querySelectorAll(".party-item");
    const endpoints = document.getElementById('page-data').dataset;

    partyItems.forEach(party => {
        party.addEventListener("click", (e) => {
            e.preventDefault();

            const candidatesItems = party.querySelectorAll(".candidate-item");
            const currentlyOpen = party.classList.contains('open');

            partyItems.forEach(i => {
                if( !i.isEqualNode(party) ) {
                    i.classList.remove('open');

                    i.querySelectorAll(".candidate-radio").forEach(radio => {
                        radio.checked = false;
                    });
                }
            });
            document.getElementById("party-" + party.dataset.partyId).checked = true;

            candidatesItems.forEach(candidate => {
                candidate.addEventListener("click", () => {
                    document.getElementById("candidate-" + candidate.dataset.candidateId).checked = true;
                });
            });

            if (!currentlyOpen) {
                party.classList.add('open');
            }
        });
    });

    function pemToArrayBuffer(pem) {
        const b64 = pem
            .replace(/-----BEGIN PUBLIC KEY-----/, '')
            .replace(/-----END PUBLIC KEY-----/, '')
            .replace(/\s/g, '');

        const binary = atob(b64);
        const buffer = new ArrayBuffer(binary.length);
        const view = new Uint8Array(buffer);

        for (let i = 0; i < binary.length; i++) {
            view[i] = binary.charCodeAt(i);
        }

        return buffer;
    }

    async function encryptVote(voteData, publicKeyPem) {
        const keyBuffer = pemToArrayBuffer(publicKeyPem);

        const publicKey = await crypto.subtle.importKey(
            "spki",
            keyBuffer,
            { name: "RSA-OAEP", hash: "SHA-1" },
            false,
            ["encrypt"]
        );

        const encrypted = await crypto.subtle.encrypt(
            { name: "RSA-OAEP" },
            publicKey,
            new TextEncoder().encode(voteData)
        );

        return btoa(String.fromCharCode(...new Uint8Array(encrypted)));
    }

    async function submitEndpoint() {
        const formData = new FormData(document.getElementById('voteForm'));
        const party = formData.get('party');
        const candidate = formData.get('candidate');
        const voterId = document.getElementById('voterId').value;
        const voterPin = document.getElementById('voterPin').value;

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

        if(!voterPin) {
            alert('Please insert your secret key!');
            return;
        }

        const resultAuth = await axios.post(endpoints.authenticateEndpoint, {
            person_id: voterId,
            pin: voterPin
        });

        if(resultAuth.data.error !== undefined) {
            alert('Authentication error: ' + resultAuth.data.error);
            return;
        }

        const resultPublicKey = await axios.get(endpoints.publicEndpoint, {
            headers: {
                'Authorization': 'Bearer ' + resultAuth.data.token
            }
        });
        
        const payload = JSON.stringify({
            party: party,
            candidate: candidate,
            voter_id: voterId,
            timestamp: new Date().toISOString()
        });

        const encryptedVote = await encryptVote(payload, resultPublicKey.data.public_key);

        axios.post(endpoints.submitEndpoint, {
            encrypted_vote: encryptedVote
        }, {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + resultAuth.data.token
            } 
        })
        .then(response => {
            if(response.status !== undefined && response.status == 200) {
                alert( response.data.message );

                if(response.data.code !== undefined && response.data.code < 0) {
                    return;
                }

                setTimeout(() => {
                    window.location.replace(endpoints.redirectEndpoint);
                }, 270);
            }
        })
        .catch(error => {
            console.error('Error submitting vote:', error);
        });
    }

    document.getElementById('sendEncryptedData').addEventListener('click', submitEndpoint);    
});