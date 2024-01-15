<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFC RFID Reader</title>
</head>
<body>
    <h1>NFC RFID Reader</h1>
     <audio src="{{asset('system/public/audio.mp3')}}"></audio>

    <!-- Tambahkan elemen untuk menampilkan hasil -->
    <div id="rfidResult"></div>

    <!-- Tambahkan elemen audio -->
    <audio id="scanAudio" src="{{asset('system/public/audio.mp3')}}"></audio>

    <!-- Tambahkan tombol untuk memicu pembacaan NFC -->
    <button onclick="startNFCScan()">Start NFC Scan</button>

    <script>
        async function startNFCScan() {
            const resultElement = document.getElementById('rfidResult');
            const scanAudio = document.getElementById('scanAudio');

            try {
                if ('NDEFReader' in window) {
                    const reader = new NDEFReader();
                    reader.addEventListener('reading', ({ message, serialNumber }) => {
                        console.log(`Serial Number: ${serialNumber}`);
                        console.log(`Message Records: ${JSON.stringify(message.records)}`);
                        
                        // Display the result in the HTML element
                        resultElement.innerHTML = `<p>RFID Serial Number: ${serialNumber}</p>`;

                        // Attempt to play the scan audio
                        scanAudio.play().catch(error => {
                            console.error(`Error playing audio: ${error}`);
                        });
                    });

                    reader.addEventListener('error', (event) => {
                        console.error(`Error reading NFC: ${event.message}`);
                        alert(`Error reading NFC: ${event.message}`);
                    });

                    // Start NFC reading
                    await reader.scan();
                } else {
                    console.error('NDEFReader not supported.');
                    alert('NFC tidak didukung pada peramban ini.');
                }
            } catch (error) {
                console.error(`Error starting NFC scan: ${error}`);
                alert(`Error starting NFC scan: ${error}`);
            }
        }
    </script>
</body>
</html>
