<?php
class GPIOReader {
    private $pins = [17, 18, 27, 22, 23, 24, 25, 4];  // Example GPIO pins

    public function readPin($pin) {
        $command = "gpio -g read " . escapeshellarg($pin);
        exec($command, $output, $return_var);
        
        if ($return_var !== 0) {
            return null;
        }
        
        return trim($output[0]);
    }

    public function getAllPinStates() {
        $states = [];
        foreach ($this->pins as $pin) {
            $value = $this->readPin($pin);
            $states[$pin] = [
                'value' => $value,
                'status' => ($value === '1') ? 'Active' : 'Inactive',
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
        return $states;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raspberry Pi GPIO Status</title>
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="refresh" content="5">
</head>
<body>
    <div class="container">
        <h1>Raspberry Pi GPIO Status</h1>
        
        <table>
            <thead>
                <tr>
                    <th>GPIO Pin</th>
                    <th>Status</th>
                    <th>Value</th>
                    <th>Last Update</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $gpio = new GPIOReader();
                $pinStates = $gpio->getAllPinStates();
                
                foreach ($pinStates as $pin => $state) {
                    $statusClass = ($state['status'] === 'Active') ? 'status-active' : 'status-inactive';
                    echo "<tr>";
                    echo "<td>GPIO {$pin}</td>";
                    echo "<td class='{$statusClass}'>{$state['status']}</td>";
                    echo "<td>{$state['value']}</td>";
                    echo "<td>{$state['timestamp']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Refresh the page every 5 seconds
        setTimeout(function() {
            location.reload();
        }, 5000);
    </script>
</body>
</html>