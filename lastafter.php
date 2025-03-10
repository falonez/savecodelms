<iframe id="myIframe" src="http://localhost/3-Multilateral-data/index.html" width="100%" height="600" frameborder="0" allowfullscreen="" sandbox="allow-scripts allow-same-origin"></iframe>

<p>Pesan dari Iframe: <span id="output">Menunggu pesan...</span></p>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const iframe = document.getElementById("myIframe");

        // Menerima pesan dari iframe
        window.addEventListener("message", (event) => {
            // Pastikan pesan berasal dari iframe yang benar
            if (event.origin !== "http://localhost") {
                console.warn("Pesan dari sumber tidak dikenal:", event.origin);
                return;
            }

            console.log("Pesan diterima dari iframe:", event.data);

            // Ignore messages from React Developer Tools or other extensions
            if (event.data && event.data.source === 'react-devtools-content-script') {
                return;
            }

            // Periksa apakah data memiliki properti 'score'
            if (event.data && typeof event.data === "object" && "score" in event.data) {
                document.getElementById("output").innerText = `Score: ${event.data.score}`;
            }
        });

        // Kirim pesan ke iframe setelah iframe selesai dimuat
        iframe.onload = () => {
            iframe.contentWindow.postMessage("Halo dari parent!", "http://localhost");
        };
    });
</script>
