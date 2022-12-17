<select id="attributes[{{$count}}][attribute_inputtype][value]" name="attributes[{{$count}}][attribute_inputtype][value]" class="form-control" autofocus>
<?php
foreach($tables as $table) {
  if($tableUuid === $table->uuid) {
    echo "<option value='$tableUuid' selected>$table->table_name</option>";
  } else {
    echo "<option value='$table->uuid'>$table->table_name</option>";
  }  
}
?>
</select>