//   Initialization and scripts for international phone number format and validation

const input = document.querySelector("#phone");

const iti = window.intlTelInput(input, {    
    initialCountry: "auto",    
    nationalMode: true,
    // separateDialCode: true,
    strictMode: true,
    /* THIS WILL BE ACTIVATED UPON DELIVERY ---- It can be blocked for making too many requests */
    geoIpLookup: callback => {
        fetch("https://ipapi.co/json")
            .then(res => res.json())
            .then(data => callback(data.country_code))
            .catch(() => callback("ca"));
    },    
    loadUtils: () => import("../libraries/inttl-tel-input/js/utils.js?1743167482095"),
    autoPlaceholder: "aggressive", // Better autocomplete handling
    formatOnDisplay: true,    
});

// deals with autofill
input.addEventListener('change', function() {
  if (iti && input.value && !iti.getSelectedCountryData().iso2) {
    // Try to guess the country based on the input value
    iti.setNumber(input.value);
  }
});

// Corrects styling as modifying iti css doesn't work.
document.addEventListener('DOMContentLoaded', function() {
    input.style.width = '100%';    
});