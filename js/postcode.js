/**
 * HouseAidPro — Postcode Lookup (postcode.js)
 * Uses the free postcodes.io API for UK postcodes.
 */
const PostcodeLookup = (function () {
    'use strict';

    const API = 'https://api.postcodes.io/postcodes/';

    async function lookup(postcode) {
        const clean = postcode.replace(/\s+/g, '').toUpperCase();
        if (clean.length < 5) return { success: false, error: 'Please enter a valid postcode.' };

        try {
            const res = await fetch(API + encodeURIComponent(clean));
            const data = await res.json();
            if (data.status === 200 && data.result) {
                return {
                    success: true,
                    address: {
                        postcode: data.result.postcode,
                        town: data.result.admin_district || data.result.parish || '',
                        county: data.result.admin_county || data.result.region || '',
                        country: data.result.country || 'England'
                    }
                };
            }
            return { success: false, error: 'Postcode not found.' };
        } catch {
            return { success: false, error: 'Lookup service unavailable. Please enter manually.' };
        }
    }

    function init(postcodeInputId, lookupBtnId, resultFields) {
        const input = document.getElementById(postcodeInputId);
        const btn = document.getElementById(lookupBtnId);
        if (!input || !btn) return;

        btn.addEventListener('click', async () => {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner spinner--sm"></span>';
            const result = await lookup(input.value);
            btn.disabled = false;
            btn.textContent = 'Look Up';

            if (result.success) {
                if (resultFields.town) document.getElementById(resultFields.town).value = result.address.town;
                if (resultFields.county) document.getElementById(resultFields.county).value = result.address.county;
                if (resultFields.postcode) document.getElementById(resultFields.postcode).value = result.address.postcode;
                if (resultFields.country) document.getElementById(resultFields.country).value = result.address.country;
            } else {
                alert(result.error);
            }
        });
    }

    return { init, lookup };
})();
