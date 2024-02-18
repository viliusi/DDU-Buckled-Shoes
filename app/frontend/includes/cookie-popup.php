<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log("Test");

    // Check if the cookie consent has been accepted
    if (document.cookie.split(";").some((item) => item.trim().startsWith("cookie-consent="))) {
        return;
    }

    // Create the cookie consent banner
    var banner = document.createElement("div");
    banner.innerHTML = `
            <div style="position:fixed;bottom:0;left:0;width:100%;background-color:#e9ecef;padding:20px;text-align:center;z-index:10000;">
                <span style="font-size:18px;margin-right:20px;color:black;">By using this site, you agree to our <a href="site-policies.php#cookie-policy" target="_blank">cookie policy</a>.</span>
                <button style="font-size:18px;background:none;border:none;cursor:pointer;">X</button>
            </div>
        `;

    // Append the banner to the body
    document.body.appendChild(banner);

    // Add an event listener to the "X" button
    banner.querySelector("button").addEventListener("click", function () {
        // Set a cookie to remember that the consent has been accepted
        document.cookie = "cookie-consent=accepted; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";

        // Remove the banner
        document.body.removeChild(banner);
    });
});
</script>