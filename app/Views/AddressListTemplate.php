<table>
  <tr>
    <th>Name</th>
    <th>Country</th>
    <th>State</th>
    <th>City</th>
    <th>Zip code</th>
    <th>Status</th>
  </tr>
  <?php foreach ($data as $row): ?>
  <tr>
    <td style="text-align: center;"><?php echo $row['name']?></td>
    <td style="text-align: center;"><?php echo $row['country']?></td>
    <td style="text-align: center;"><?php echo $row['state']?></td>
    <td style="text-align: center;"><?php echo $row['city']?></td>
    <td style="text-align: center;"><?php echo $row['zipcode']?></td>
    <td style="text-align: center;"><?php echo $row['status']?></td>
  </tr>
  <?php endforeach; ?>
</table>