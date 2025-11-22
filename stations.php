<?php
$response = file_get_contents("http://localhost/ev_project/api/getStations.php");

$data = json_decode($response, true);
$stations = $data["data"];
?>
<?php foreach ($stations as $s): ?>
<tr>
    <td><?= $s['name'] ?></td>
    <td><?= $s['connector_type'] ?></td>
    <td><?= $s['power_kw'] ?> kW</td>
    <td><?= $s['address'] ?></td>
</tr>
<?php endforeach; ?>
<script>
fetch("http://localhost/ev_project/api/getStations.php")
    .then(res => res.json())
    .then(data => console.log(data));
</script>
