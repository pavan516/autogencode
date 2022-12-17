@extends('layouts.default')
@include('includes.navbar')

@section('container')

<!-- Feature auth enable -->
<?php $authentcation = "NO";
if($project->programming_language === "NODE_JS") {
  $authentication = "YES";
} else {
  if($feature->enable === "YES") $authentication = "YES";
}?>
<!-- Feature auth enable -->

<!-- Container -->
<div class="container-fluid">

  <!-- Breadcrumbs-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
    <a href="/projects">Dashboard / Projects</a>
    </li>
    <li class="breadcrumb-item active">{{strtoupper($project->project_name)}} ( Create Table & Attributes )</li>
  </ol>
  <!-- End Of BreadCrumb -->

  <!-- Progress -->
  <ol class="progtrckr" data-progtrckr-steps="5">
    <li class="progtrckr-done">Select Features</li>
    <li class="progtrckr-done">Create Database</li>
    <li class="progtrckr-todo">Create Tables</li>
    <li class="progtrckr-todo">Generate</li>
  </ol><br>
  <!-- End Of progress -->

  <!-- Add/Edit New Tables -->
  <div style="text-align:right;">
    <button style="background-color:#000000;color:white;" class="btn btn-primary" data-toggle="modal" data-target="#add_edit_tables">
      Add Tables
    </button>
  </div><br>
  <!-- End Of Add/Edit New Tables -->

  @if($authentcation === "YES")
    <!-- Mandatory Tables USERS & SESSIONS- Default Tables -->
    <!-- Users -->
    <div class="card mb-3">
      <div class="card-header bg-primary cursor" data-toggle="collapse" data-target="#defaultusers">
        <i class="fa fa-table"></i> 
          Jwt-Tokens (Default)
        <i class="fa fa-angle-down custom"></i> 
      </div>
      <div id="defaultusers" class="collapse">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="text-align:center;">Name</th>
                  <th style="text-align:center;">Datatype</th>
                  <th style="text-align:center;">Length</th>
                  <th style="text-align:center;">Default</th>
                  <th style="text-align:center;">Attributes</th>
                  <th style="text-align:center;">Null</th>
                  <th style="text-align:center;">Index</th>
                  <th style="text-align:center;">A_I</th>
                  <th style="text-align:center;">Validation</th>
                </tr>
              </thead>
              <!-- Default data -->
              <?php
                $body[0]['attribute_name'] = "id";
                $body[0]['attribute_datatype'] = "INT";
                $body[0]['attribute_length'] = "11";
                $body[0]['attribute_index'] = "PRIMARY";
                $body[0]['attribute_increment'] = "checked";

                $body[1]['attribute_name'] = "user_uuid";
                $body[1]['attribute_datatype'] = "VARCHAR";
                $body[1]['attribute_length'] = "48";
                $body[1]['attribute_index'] = "";
                $body[1]['attribute_increment'] = "";

                $body[2]['attribute_name'] = "session_id";
                $body[2]['attribute_datatype'] = "VARCHAR";
                $body[2]['attribute_length'] = "128";
                $body[2]['attribute_index'] = "";
                $body[2]['attribute_increment'] = "";

                $body[3]['attribute_name'] = "jwt_token";
                $body[3]['attribute_datatype'] = "VARCHAR";
                $body[3]['attribute_length'] = "255";
                $body[3]['attribute_index'] = "";
                $body[3]['attribute_increment'] = "";

                $body[4]['attribute_name'] = "created_date";
                $body[4]['attribute_datatype'] = "DATETIME";
                $body[4]['attribute_length'] = "";
                $body[4]['attribute_index'] = "";
                $body[4]['attribute_increment'] = "";
              ?>
              <!-- End of default data -->
              @foreach($body as $item)
              <tr>
                <!-- Attribute Name -->
                <td width="13%"><input type="text" class="form-control" value="{{$item['attribute_name']}}" disabled></td>
                <!-- End Of Attribute Name -->

                <!-- Datatype -->
                <td width="13%"><input type="text" class="form-control" value="{{$item['attribute_datatype']}}" disabled></td>
                <!-- End Of DataType -->

                <!-- Length -->
                <td width="13%"><input type="text" class="form-control" value="{{$item['attribute_length']}}" disabled></td>
                <!-- End Of Length -->

                <!-- Default -->
                <td width="13%"><input type="text" class="form-control" value="" disabled></td>
                <!-- End Of Default -->

                <!-- Attributes -->
                <td width="10%"><input type="text" class="form-control" value="" disabled></td>
                <!-- End Of Attributes -->

                <!-- Null -->
                <td width="5%"><input type="checkbox" class="form-control" value="" disabled></td>
                <!-- End Of Null -->

                <!-- Index -->
                <td width="10%"><input type="text" class="form-control" value="{{$item['attribute_index']}}" disabled></td>
                <!-- End Of Index -->

                <!-- Auto Increment -->
                <td width="5%"><input type="checkbox" class="form-control" <?php echo $item['attribute_increment']; ?> disabled></td>
                <!-- End Of Auto Increment -->

                <!-- Field Type -->
                <td width="13%"><input type="text" class="form-control" value="" disabled></td>
                <!-- End Of Field Type -->
              </tr>
              @endforeach
            </table>

          </div>
        </div>
      </div>
    </div>
    <!-- End Of Default Users -->
    <!-- Mandatory Tables - Default - Can't Edit / Add -->
  @endif

<?php $tableCount = 1; ?>
  <!-- List Of Tables -->
  @foreach($tables as $table)

    <!-- Form -->
    <form method="POST" id="insert_post_{{$table->uuid}}">
    @csrf

      <div class="card mb-3">
        <div class="card-header bg-primary cursor" data-toggle="collapse" data-target="#{{$table->uuid}}">
          <i class="fa fa-table"></i>
          {{$table->table_name}}
          <i class="fa fa-angle-down custom"></i>
        </div>
        <div id="{{$table->uuid}}" class="collapse">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th style="text-align:center;">Name</th>
                    <th style="text-align:center;">Datatype</th>
                    <th style="text-align:center;">Length</th>
                    <th style="text-align:center;">Default</th>
                    <th style="text-align:center;">Attributes</th>
                    <th style="text-align:center;">Null</th>
                    <th style="text-align:center;">Index</th>
                    <th style="text-align:center;">A_I</th>
                    <th style="text-align:center;">Validation</th>
                    <th style="text-align:center;">Delete</th>
                  </tr>
                </thead>
                <!-- Attributes Fields -->
                <tbody id="input_fields_wrap_{{$table->uuid}}">

                  <!-- ****************************************************************************************** -->
                  <!--                              Existing Records                                              -->
                  <!-- ****************************************************************************************** -->

                  <?php $count = 1; ?>
                  @foreach($attributes[$table->uuid] as $attribute)

                    <tr>
                      <input type="text" id="project_uuid" name="project_uuid" value="{{$project->uuid}}" style="display:none;">
                      <input type="text" id="table_uuid" name="table_uuid" value="{{$table->uuid}}" style="display:none;">

                      <!-- Attribute Name -->
                      <td width="13%"><input type="text" id="attributes[{{$count}}][attribute_name]" name="attributes[{{$count}}][attribute_name]" class="form-control" value="{{$attribute->attribute_name}}" required></td>
                      <!-- End Of Attribute Name -->

                      <!-- Datatype -->
                      <td width="13%">
                        <select id="attributes[{{$count}}][attribute_datatype]" name="attributes[{{$count}}][attribute_datatype]" class="form-control">
                          <option value="{{$attribute->attribute_datatype}}" selected>{{$attribute->attribute_datatype}}</option> 
                          <option value="VARCHAR">VARCHAR</option>
                          <option value="INT">INT</option>
                          <option value="FLOAT">FLOAT</option>
                          <option value="TEXT">TEXT</option>
                          <option value="BOOLEAN">BOOLEAN</option>
                          <option value="BLOB">BLOB</option>
                          <option value="DATE">DATE</option>
                          <option value="DATETIME">DATETIME</option>
                          <option value="TIMESTAMP">TIMESTAMP</option>
                          <option disabled="disabled">-</option>
                          <option value="TINYINT">TINYINT</option>
                          <option value="SMALLINT">SMALLINT</option>
                          <option value="MEDIUMINT">MEDIUMINT</option>
                          <option value="BIGINT">BIGINT</option>
                          <option disabled="disabled">-</option>
                          <option value="DECIMAL">DECIMAL</option>
                          <option value="DOUBLE">DOUBLE</option>
                          <option value="REAL">REAL</option>
                          <option value="BIT">BIT</option>
                          <option value="SERIAL">SERIAL</option>
                          <option disabled="disabled">-</option>
                          <option value="CHAR">CHAR</option>
                          <option value="TINYTEXT">TINYTEXT</option>
                          <option value="TEXT">TEXT</option>
                          <option value="MEDIUMTEXT">MEDIUMTEXT</option>
                          <option value="LONGTEXT">LONGTEXT</option>
                          <option disabled="disabled">-</option>
                          <option value="BINARY">BINARY</option>
                          <option value="VARBINARY">VARBINARY</option>
                          <option disabled="disabled">-</option>
                          <option value="TINYBLOB">TINYBLOB</option>
                          <option value="MEDIUMBLOB">MEDIUMBLOB</option>
                          <option value="LONGBLOB">LONGBLOB</option>
                          <option disabled="disabled">-</option>
                          <option value="ENUM">ENUM</option>
                          <option value="SET">SET</option>
                          <option disabled="disabled">-</option>
                          <option value="TIME">TIME</option>
                          <option value="YEAR">YEAR</option>
                          <option disabled="disabled">-</option>
                          <option value="GEOMETRY">GEOMETRY</option>
                          <option value="POINT">POINT</option>
                          <option value="LINESTRING">LINESTRING</option>
                          <option value="POLYGON">POLYGON</option>
                          <option value="MULTIPOINT">MULTIPOINT</option>
                          <option value="MULTILINESTRING">MULTILINESTRING</option>
                          <option value="MULTIPOLYGON">MULTIPOLYGON</option>
                          <option value="GEOMETRYCOLLECTION">GEOMETRYCOLLECTION</option>
                        </select>
                      </td>
                      <!-- End Of DataType -->

                      <!-- Length -->
                      <td width="13%"><input type="text" id="attributes[{{$count}}][attribute_length]" name="attributes[{{$count}}][attribute_length]" class="form-control" value="{{$attribute->attribute_length}}" ></td>
                      <!-- End Of Length -->

                      <!-- Default -->
                      <td width="13%">
                        <?php $defaults = json_decode($attribute->attribute_default,true); ?>
                        <script> var default_{{$tableCount}}_{{$count}} = "default_{{$tableCount}}_{{$count}}"; </script>
                        <select id="attributes[{{$count}}][attribute_default][key]" name="attributes[{{$count}}][attribute_default][key]" class="form-control" onchange="defaultFunc(this,default_{{$tableCount}}_{{$count}})">
                          @foreach($defaults as $default)
                            @if(count($defaults)>1)
                              <option value="{{$default}}" selected>{{$default}}</option>
                              @break
                            @else
                              <option value="{{$default}}" selected>{{$default}}</option>
                            @endif
                          @endforeach
                            <option value="NONE">None</option>
                            <option value="AS_DEFINED">As Defined:</option>
                            <option value="NULL">Null</option>
                            <option value="CURRENT_TIMESTAMP">Current TimeStamp</option>
                        </select>
                        @foreach($defaults as $default)
                          @if(count($defaults)>1)
                            @if($default === "AS_DEFINED")
                              @continue
                            @endif
                            <div id="default_{{$tableCount}}_{{$count}}"><input type="text" id="attributes[{{$count}}][attribute_default][value]" name="attributes[{{$count}}][attribute_default][value]" class="form-control" value="{{$default}}" ></div>
                          @else
                            <div id="default_{{$tableCount}}_{{$count}}"></div>
                          @endif
                        @endforeach
                      </td>
                      <!-- End Of Default -->

                      <!-- Add Default Value function -->
                      <script>
                      function defaultFunc(input_type,def) {
                        // Get selected field name & value
                        var selectedText = input_type.options[input_type.selectedIndex].innerHTML;
                        var selectedValue = input_type.value;
                        if(selectedValue == "AS_DEFINED") {
                          var string = '<input type="text" id="attributes[{{$count}}][attribute_default][value]" name="attributes[{{$count}}][attribute_default][value]" class="form-control" >';
                          document.getElementById(def).innerHTML = string;
                        }  else {
                          string = '';
                          document.getElementById(def).innerHTML = string;
                        }
                      }
                      </script>
                      <!-- End Of Add Default Value function -->

                      <!-- Attributes -->
                      <td width="10%">
                        <select id="attributes[{{$count}}][attribute_attributes]" name="attributes[{{$count}}][attribute_attributes]" class="form-control">
                          <option value="{{$attribute->attribute_attributes}}" selected>{{$attribute->attribute_attributes}}</option> 
                          <option value="BINARY">BINARY</option>
                          <option value="UNSIGNED">UNSIGNED</option>
                          <option value="UNSIGNED ZEROFILL">UNSIGNED ZEROFILL</option>
                          <option value="on update CURRENT_TIMESTAMP">on update CURRENT_TIMESTAMP</option>
                        </select>
                      </td>
                      <!-- End Of Attributes -->

                      <!-- Null -->
                      <td width="5%">
                        <input type="checkbox" id="attributes[{{$count}}][attribute_null]" name="attributes[{{$count}}][attribute_null]" class="form-control" @if($attribute->attribute_null == "1" || $attribute->attribute_null == "on") checked @endif>
                      </td>
                      <!-- End Of Null -->

                      <!-- Index -->
                      <td width="10%">
                        <select id="attributes[{{$count}}][attribute_index]" name="attributes[{{$count}}][attribute_index]" class="form-control">
                          <option value="{{$attribute->attribute_index}}" selected>{{$attribute->attribute_index}}</option> 
                          <option value="PRIMARY">PRIMARY</option>
                          <option value="UNIQUE">UNIQUE</option>
                          <option value="INDEX">INDEX</option>
                          <option value="FULLTEXT">FULLTEXT</option>
                          <option value="SPATIAL">SPATIAL</option>
                        </select>
                      </td>
                      <!-- End Of Index -->

                      <!-- Auto Increment -->
                      <td width="5%">
                        <input type="checkbox" id="attributes[{{$count}}][attribute_autoincrement]" name="attributes[{{$count}}][attribute_autoincrement]" class="form-control" @if($attribute->attribute_autoincrement == "1" || $attribute->attribute_autoincrement == "on") checked @endif>
                      </td>
                      <!-- End Of Auto Increment -->

                      <!-- Field Type -->
                      <td width="13%">
                        <?php $inputTypes = json_decode($attribute->attribute_inputtype,true); ?>
                        <script> var uuid_{{$tableCount}}_{{$count}} = "uuid_{{$tableCount}}_{{$count}}"; </script>
                        <select id="attributes[{{$count}}][attribute_inputtype][key]" name="attributes[{{$count}}][attribute_inputtype][key]" class="form-control" onchange="myFunction(this,uuid_{{$tableCount}}_{{$count}})">
                          @foreach($inputTypes as $inputType)
                            @if(count($inputTypes)>1)
                              <option value="{{$inputType}}" selected>{{$inputType}}</option>
                              @break
                            @else
                              <option value="{{$inputType}}" selected>{{$inputType}}</option>
                            @endif
                          @endforeach
                          <option value="UUID">UUID</option>
                          <option value="REFERENCE_KEY">REFERENCE KEY</option>
                          <option value="REFERENCE_KEY_UUID">REFERENCE KEY & UUID</option>
                          <option value="FOREIGN_KEY">FOREIGN KEY</option>
                          <option value="EMAIL">EMAIL</option>
                          <option value="PASSWORD">PASSWORD</option>
                          <option value="NUMBER">NUMBER</option>
                          <option value="CONTACT">CONTACT</option>
                          <option value="FILE">FILE</option>
                          <option value="BOOLEAN">BOOLEAN</option>
                          <option value="HIDE">HIDE IN RESPONSE</option>
                          <option value="CURRENT_DATE">CURRENT DATE</option>
                          <option value="CURRENT_DATETIME">CURRENT DATETIME</option>
                          <option value="CURRENT_TIMESTAMP">CURRENT TIMESTAMP</option>
                        </select>
                        @foreach($inputTypes as $inputType)
                          @if(count($inputTypes)>1)
                            @if($inputType === "FOREIGN_KEY")
                              @continue
                            @endif
                            <div id="uuid_{{$tableCount}}_{{$count}}">

                              <!-- Get All Tables With Selected -->
                              <script type="text/javascript">
                              $(document).ready(function()
                              {
                                function get_tables_{{$tableCount}}_{{$count}}()
                                {
                                  $.ajax({
                                    url: "http://autogencodeigniter.com/tables/{{$project->uuid}}/{{$inputType}}/{{$count}}",
                                    method: "GET",
                                    async: false,
                                    success: function(data){
                                      $('#uuid_{{$tableCount}}_{{$count}}').html(data);
                                    }
                                  });
                                }
                                get_tables_{{$tableCount}}_{{$count}}();
                              });
                              </script>

                            </div>
                          @else
                            <div id="uuid_{{$tableCount}}_{{$count}}"></div>
                          @endif
                        @endforeach
                      </td>
                      <!-- End Of Field Type -->

                      <!-- Add Field Value function -->
                      <script>
                      function myFunction(input_type,uuid) {
                        // Assign tables & converted to js array
                        var apple = "{{$tables}}";
                        var rep = apple.replace(/&quot;/g,'"');
                        var res = JSON.parse(rep);

                        // Get selected field name & value
                        var selectedText = input_type.options[input_type.selectedIndex].innerHTML;
                        var selectedValue = input_type.value;
                        if(selectedValue == "FOREIGN_KEY") {
                          var str = '<select id="attributes[{{$count}}][attribute_inputtype][value]" name="attributes[{{$count}}][attribute_inputtype][value]" class="form-control" >'
                          for(var i=0;i<res.length;i++) {
                            str+= '<option value="'+res[i]['uuid']+'" selected>'+res[i]['table_name']+'</option>'
                          }
                          str+= '</select>';
                          document.getElementById(uuid).innerHTML = str;
                        } else {
                          str = '';
                          document.getElementById(uuid).innerHTML = str;
                        }
                      }
                      </script>
                      <!-- End Of Add Field Value function -->

                      <!-- Delete Button -->
                      <td width="4%" style="text-align:center">
                        <a href="#" style="background-color:#000000;color:white;" class="remove_field_{{$table->uuid}} btn btn-default"><i class="fa fa-trash-o"></i></a>
                      </td>
                      <!-- End Of Delete Button -->

                    </tr>

                  <?php $count++; ?>
                  @endforeach
                  <?php $count--; ?>

                  <!-- ****************************************************************************************** -->
                  <!--                                      New Record                                            -->
                  <!-- ****************************************************************************************** -->

                    @if($count == 0)

                      <?php $count++; ?>
                      <input type="text" id="project_uuid" name="project_uuid" value="{{$project->uuid}}" style="display:none;">
                      <input type="text" id="table_uuid" name="table_uuid" value="{{$table->uuid}}" style="display:none;">

                      <!-- Attribute Name -->
                      <td width="13%"><input type="text" id="attributes[{{$count}}][attribute_name]" name="attributes[{{$count}}][attribute_name]" class="form-control" required autofocus></td>
                      <!-- End Of Attribute Name -->

                      <!-- Datatype -->
                      <td width="13%">
                        <select id="attributes[{{$count}}][attribute_datatype]" name="attributes[{{$count}}][attribute_datatype]" class="form-control" >
                          <option value="VARCHAR" selected>VARCHAR</option>
                          <option value="INT">INT</option>
                          <option value="FLOAT">FLOAT</option>
                          <option value="TEXT">TEXT</option>
                          <option value="BOOLEAN">BOOLEAN</option>
                          <option value="BLOB">BLOB</option>
                          <option value="DATE">DATE</option>
                          <option value="DATETIME">DATETIME</option>
                          <option value="TIMESTAMP">TIMESTAMP</option>
                          <option disabled="disabled">-</option>
                          <option value="TINYINT">TINYINT</option>
                          <option value="SMALLINT">SMALLINT</option>
                          <option value="MEDIUMINT">MEDIUMINT</option>
                          <option value="BIGINT">BIGINT</option>
                          <option disabled="disabled">-</option>
                          <option value="DECIMAL">DECIMAL</option>
                          <option value="DOUBLE">DOUBLE</option>
                          <option value="REAL">REAL</option>
                          <option value="BIT">BIT</option>
                          <option value="SERIAL">SERIAL</option>
                          <option disabled="disabled">-</option>
                          <option value="CHAR">CHAR</option>
                          <option value="TINYTEXT">TINYTEXT</option>
                          <option value="TEXT">TEXT</option>
                          <option value="MEDIUMTEXT">MEDIUMTEXT</option>
                          <option value="LONGTEXT">LONGTEXT</option>
                          <option disabled="disabled">-</option>
                          <option value="BINARY">BINARY</option>
                          <option value="VARBINARY">VARBINARY</option>
                          <option disabled="disabled">-</option>
                          <option value="TINYBLOB">TINYBLOB</option>
                          <option value="MEDIUMBLOB">MEDIUMBLOB</option>
                          <option value="LONGBLOB">LONGBLOB</option>
                          <option disabled="disabled">-</option>
                          <option value="ENUM">ENUM</option>
                          <option value="SET">SET</option>
                          <option disabled="disabled">-</option>
                          <option value="TIME">TIME</option>
                          <option value="YEAR">YEAR</option>
                          <option disabled="disabled">-</option>
                          <option value="GEOMETRY">GEOMETRY</option>
                          <option value="POINT">POINT</option>
                          <option value="LINESTRING">LINESTRING</option>
                          <option value="POLYGON">POLYGON</option>
                          <option value="MULTIPOINT">MULTIPOINT</option>
                          <option value="MULTILINESTRING">MULTILINESTRING</option>
                          <option value="MULTIPOLYGON">MULTIPOLYGON</option>
                          <option value="GEOMETRYCOLLECTION">GEOMETRYCOLLECTION</option>
                        </select>
                      </td>
                      <!-- End Of DataType -->

                      <!-- Length -->
                      <td width="13%"><input type="text" id="attributes[{{$count}}][attribute_length]" name="attributes[{{$count}}][attribute_length]" class="form-control" ></td>
                      <!-- End Of Length -->

                      <!-- Default -->
                      <td width="13%">
                        <script> var default_{{$tableCount}}_{{$count}} = "default_{{$tableCount}}_{{$count}}"; </script>
                        <select id="attributes[{{$count}}][attribute_default][key]" name="attributes[{{$count}}][attribute_default][key]" class="form-control" onchange="defaultFunc1(this,default_{{$tableCount}}_{{$count}})" >
                          <option value="NONE" selected>None</option>
                          <option value="AS_DEFINED">As Defined:</option>
                          <option value="NULL">Null</option>
                          <option value="CURRENT_TIMESTAMP">Current TimeStamp</option>
                        </select>
                        <div id="default_{{$tableCount}}_{{$count}}"></div>
                      </td>
                      <!-- End Of Default -->

                      <!-- Add Default Value function -->
                      <script>function defaultFunc1(input_type,def) {
                        // Get selected field name & value
                        var selectedText = input_type.options[input_type.selectedIndex].innerHTML;
                        var selectedValue = input_type.value;
                        if(selectedValue == "AS_DEFINED") {
                          var string = '<input type="text" id="attributes[{{$count}}][attribute_default][value]" name="attributes[{{$count}}][attribute_default][value]" class="form-control" >';
                          document.getElementById(def).innerHTML = string;
                        }  else {
                          string = '';
                          document.getElementById(def).innerHTML = string;
                        }
                      }
                      </script>
                      <!-- End Of Add Default Value function -->

                      <!-- Add Default Value function -->
                      <script>function defaultFunc2(input_type,def,x) {
                        // Get selected field name & value
                        var selectedText = input_type.options[input_type.selectedIndex].innerHTML;
                        var selectedValue = input_type.value;
                        if(selectedValue == "AS_DEFINED") {
                          var string = '<input type="text" id="attributes['+x+'][attribute_default][value]" name="attributes['+x+'][attribute_default][value]" class="form-control" autofocus>';
                          def.innerHTML = string;
                        }  else {
                          string = '';
                          def.innerHTML = string;
                        }
                      }
                      </script>
                      <!-- End Of Add Default Value function -->

                      <!-- Attributes -->
                      <td width="10%">
                        <select id="attributes[{{$count}}][attribute_attributes]" name="attributes[{{$count}}][attribute_attributes]" class="form-control">
                          <option value="" selected="selected">---</option>
                          <option value="BINARY">BINARY</option>
                          <option value="UNSIGNED">UNSIGNED</option>
                          <option value="UNSIGNED ZEROFILL">UNSIGNED ZEROFILL</option>
                          <option value="on update CURRENT_TIMESTAMP">on update CURRENT_TIMESTAMP</option>
                        </select>
                      </td>
                      <!-- End Of Attributes -->

                      <!-- Null -->
                      <td width="5%">
                        <input type="checkbox" id="attributes[{{$count}}][attribute_null]" name="attributes[{{$count}}][attribute_null]" value="1" class="form-control">
                      </td>
                      <!-- End Of Null -->

                      <!-- Index -->
                      <td width="10%">
                        <select id="attributes[{{$count}}][attribute_index]" name="attributes[{{$count}}][attribute_index]" class="form-control">
                          <option value="">---</option>
                          <option value="PRIMARY">PRIMARY</option>
                          <option value="UNIQUE">UNIQUE</option>
                          <option value="INDEX">INDEX</option>
                          <option value="FULLTEXT">FULLTEXT</option>
                          <option value="SPATIAL">SPATIAL</option>
                        </select>
                      </td>
                      <!-- End Of Index -->

                      <!-- Auto Increment -->
                      <td width="5%">
                        <input type="checkbox" id="attributes[{{$count}}][attribute_autoincrement]" name="attributes[{{$count}}][attribute_autoincrement]" value="1" class="form-control">
                      </td>
                      <!-- End Of Auto Increment -->

                      <!-- Field Type -->
                      <td width="13%">
                        <script> var uuid_<?php echo $tableCount."_".$count; ?> = "uuid_{{$tableCount}}_{{$count}}"; </script>
                        <select id="attributes[{{$count}}][attribute_inputtype][key]" name="attributes[{{$count}}][attribute_inputtype][key]" class="form-control" onchange="myFunction1(this,uuid_<?php echo $tableCount.'_'.$count; ?>)" >
                          <option value="" selected="selected">---</option>
                          <option value="UUID">UUID</option>
                          <option value="REFERENCE_KEY">REFERENCE KEY</option>
                          <option value="REFERENCE_KEY_UUID">REFERENCE KEY & UUID</option>
                          <option value="FOREIGN_KEY">FOREIGN KEY</option>
                          <option value="EMAIL">EMAIL</option>
                          <option value="PASSWORD">PASSWORD</option>
                          <option value="NUMBER">NUMBER</option>
                          <option value="CONTACT">CONTACT</option>
                          <option value="FILE">FILE</option>
                          <option value="BOOLEAN">BOOLEAN</option>
                          <option value="HIDE">HIDE IN RESPONSE</option>
                          <option value="CURRENT_DATE">CURRENT DATE</option>
                          <option value="CURRENT_DATETIME">CURRENT DATETIME</option>
                          <option value="CURRENT_TIMESTAMP">CURRENT TIMESTAMP</option>
                        </select>
                        <div id="uuid_{{$tableCount}}_{{$count}}"></div>
                      </td>
                      <!-- End Of Field Type -->

                      <!-- Add Field Value function -->
                      <script>function myFunction1(input_type,uuid) {
                        // Assign tables & converted to js array
                        var apple = "{{$tables}}";
                        var rep = apple.replace(/&quot;/g,'"');
                        var res = JSON.parse(rep);

                        // Get selected field name & value
                        var selectedText = input_type.options[input_type.selectedIndex].innerHTML;
                        var selectedValue = input_type.value;
                        if(selectedValue == "FOREIGN_KEY") {
                          var str = '<select id="attributes[{{$count}}][attribute_inputtype][value]" name="attributes[{{$count}}][attribute_inputtype][value]" class="form-control" >'
                          for(var i=0;i<res.length;i++) {
                            str+= '<option value="'+res[i]['uuid']+'" selected>'+res[i]['table_name']+'</option>'
                          }
                          str+= '</select>';
                          document.getElementById(uuid).innerHTML = str;
                        }  else {
                          str = '';
                          document.getElementById(uuid).innerHTML = str;
                        }
                      }
                      </script>
                      <!-- End Of Add Field Value function -->

                      <!-- Add Field Value function -->
                      <script>function myFunction2(input_type,uuid,count) {
                        // Assign tables & converted to js array
                        var apple = "{{$tables}}";
                        var rep = apple.replace(/&quot;/g,'"');
                        var res = JSON.parse(rep);

                        // Get selected field name & value
                        var selectedText = input_type.options[input_type.selectedIndex].innerHTML;
                        var selectedValue = input_type.value;
                        if(selectedValue == "FOREIGN_KEY") {
                          var str = '<select id="attributes['+count+'][attribute_inputtype][value]" name="attributes['+count+'][attribute_inputtype][value]" class="form-control" >'
                          for(var i=0;i<res.length;i++) {
                            str+= '<option value="'+res[i]['uuid']+'" selected>'+res[i]['table_name']+'</option>'
                          }
                          str+= '</select>';
                          uuid.innerHTML = str;
                        }  else {
                          str = '';
                          uuid.innerHTML = str;
                        }
                      }
                      </script>
                      <!-- End Of Add Field Value function -->

                      <!-- Delete Button -->
                      <td  width="4%" style="text-align:center">
                        <a href="#" style="background-color:#000000;color:white;" class="remove_field_{{$table->uuid}} btn btn-default"><i class="fa fa-trash-o"></i></a>
                      </td>
                      <!-- End Of Delete Button -->

                    @endif

                    <!-- Add Field Value function -->
                    <script>function myFunction2(input_type,uuid,count) {
                      // Assign tables & converted to js array
                      var apple = "{{$tables}}";
                      var rep = apple.replace(/&quot;/g,'"');
                      var res = JSON.parse(rep);

                      // Get selected field name & value
                      var selectedText = input_type.options[input_type.selectedIndex].innerHTML;
                      var selectedValue = input_type.value;
                      if(selectedValue == "FOREIGN_KEY") {
                        var str = '<select id="attributes['+count+'][attribute_inputtype][value]" name="attributes['+count+'][attribute_inputtype][value]" class="form-control" >'
                        for(var i=0;i<res.length;i++) {
                          str+= '<option value="'+res[i]['uuid']+'" selected>'+res[i]['table_name']+'</option>'
                        }
                        str+= '</select>';
                        uuid.innerHTML = str;
                      }  else {
                        str = '';
                        uuid.innerHTML = str;
                      }
                    }
                    </script>
                    <!-- End Of Add Field Value function -->

                    <!-- Add Default Value function -->
                    <script>function defaultFunc2(input_type,def,x) {
                        // Get selected field name & value
                        var selectedText = input_type.options[input_type.selectedIndex].innerHTML;
                        var selectedValue = input_type.value;
                        if(selectedValue == "AS_DEFINED") {
                          var string = '<input type="text" id="attributes['+x+'][attribute_default][value]" name="attributes['+x+'][attribute_default][value]" class="form-control" autofocus>';
                          def.innerHTML = string;
                        }  else {
                          string = '';
                          def.innerHTML = string;
                        }
                      }
                      </script>
                      <!-- End Of Add Default Value function -->

                  </tr>
                </tbody>
                <!-- End Of Attributes Field -->
              </table>
            </div>
          </div>

          <!-- Table Footer -->
          <div class="card-footer" style="text-align:center">
            <button id="add_field_button_{{$table->uuid}}" class="btn btn-primary" style="background-color:#000000;color:white;"><i class="fa fa-plus"></i></button>
            <button type="submit" class="btn btn-primary" style="background-color:#000000;color:white;">Save</button>
            <div id="result_{{$table->uuid}}" style="color:green"></div>
          </div>
          <!-- End Of Table Footer -->

          <!-- Adding New table fields -->
          <script type="text/javascript">
          jQuery(document).ready(function() {
            var max_fields      = 30; //maximum input boxes allowed
            var wrapper   		= $("#input_fields_wrap_{{$table->uuid}}"); //Fields wrapper
            var add_button      = $("#add_field_button_{{$table->uuid}}"); //Add button ID

            var x = <?php echo $count; ?>; //initlal text box count
            jQuery(add_button).click(function(e){ //on add input button click
              e.preventDefault();
              if(x < max_fields){ //max input box allowed
                x++; //text box increment
                var totalValue = 'uuid_{{$tableCount}}_'+x;
                var defaultValue = 'default_{{$tableCount}}_'+x;

                $(wrapper).append('<tr><input type="text" id="project_uuid" name="project_uuid" value="{{$project->uuid}}" style="display:none;"><input type="text" id="table_uuid" name="table_uuid" value="{{$table->uuid}}" style="display:none;"><td width="13%"><input type="text" id="attributes['+x+'][attribute_name]" name="attributes['+x+'][attribute_name]" class="form-control" required autofocus></td><td width="13%"><select id="attributes['+x+'][attribute_datatype]" name="attributes['+x+'][attribute_datatype]" class="form-control" ><option value="VARCHAR" selected>VARCHAR</option><option value="INT">INT</option><option value="FLOAT">FLOAT</option><option value="TEXT">TEXT</option><option value="BOOLEAN">BOOLEAN</option><option value="BLOB">BLOB</option><option value="DATE">DATE</option><option value="DATETIME">DATETIME</option><option value="TIMESTAMP">TIMESTAMP</option><option disabled="disabled">-</option><option value="TINYINT">TINYINT</option><option value="SMALLINT">SMALLINT</option><option value="MEDIUMINT">MEDIUMINT</option><option value="BIGINT">BIGINT</option><option disabled="disabled">-</option><option value="DECIMAL">DECIMAL</option><option value="DOUBLE">DOUBLE</option><option value="REAL">REAL</option><option value="BIT">BIT</option><option value="SERIAL">SERIAL</option>option disabled="disabled">-</option><option value="CHAR">CHAR</option><option value="TINYTEXT">TINYTEXT</option><option value="TEXT">TEXT</option><option value="MEDIUMTEXT">MEDIUMTEXT</option><option value="LONGTEXT">LONGTEXT</option><option disabled="disabled">-</option><option value="BINARY">BINARY</option><option value="VARBINARY">VARBINARY</option><option disabled="disabled">-</option><option value="TINYBLOB">TINYBLOB</option><option value="MEDIUMBLOB">MEDIUMBLOB</option><option value="LONGBLOB">LONGBLOB</option><option disabled="disabled">-</option><option value="ENUM">ENUM</option><option value="SET">SET</option><option disabled="disabled">-</option><option value="TIME">TIME</option><option value="YEAR">YEAR</option><option disabled="disabled">-</option><option value="GEOMETRY">GEOMETRY</option><option value="POINT">POINT</option><option value="LINESTRING">LINESTRING</option><option value="POLYGON">POLYGON</option><option value="MULTIPOINT">MULTIPOINT</option><option value="MULTILINESTRING">MULTILINESTRING</option><option value="MULTIPOLYGON">MULTIPOLYGON</option><option value="GEOMETRYCOLLECTION">GEOMETRYCOLLECTION</option></select></td><td width="13%"><input type="text" id="attributes['+x+'][attribute_length]" name="attributes['+x+'][attribute_length]" class="form-control" ></td><td width="13%"><script>let defaultValue = default_{{$tableCount}}_'+x+';</' + 'script><select id="attributes['+x+'][attribute_default][key]" name="attributes['+x+'][attribute_default][key]" class="form-control" onchange="defaultFunc2(this,'+defaultValue+','+x+')" ><option value="NONE" selected>None</option><option value="AS_DEFINED">As Defined:</option><option value="NULL">Null</option><option value="CURRENT_TIMESTAMP">Current TimeStamp</option></select><div id='+defaultValue+'></div></td><td width="10%"><script>let totalValue = uuid_{{$tableCount}}_'+x+';</' + 'script><select id="attributes['+x+'][attribute_attributes]" name="attributes['+x+'][attribute_attributes]" class="form-control"><option value="" selected="selected">---</option><option value="BINARY">BINARY</option><option value="UNSIGNED">UNSIGNED</option><option value="UNSIGNED ZEROFILL">UNSIGNED ZEROFILL</option><option value="on update CURRENT_TIMESTAMP">on update CURRENT_TIMESTAMP</option></select></td><td width="5%"><input type="checkbox" id="attributes['+x+'][attribute_null]" name="attributes['+x+'][attribute_null]" value="1" class="form-control"></td><td width="10%"><select id="attributes['+x+'][attribute_index]" name="attributes['+x+'][attribute_index]" class="form-control"><option value="">---</option><option value="PRIMARY">PRIMARY</option><option value="UNIQUE">UNIQUE</option><option value="INDEX">INDEX</option><option value="FULLTEXT">FULLTEXT</option><option value="SPATIAL">SPATIAL</option></select></td><td width="5%"><input type="checkbox" id="attributes['+x+'][attribute_autoincrement]" name="attributes['+x+'][attribute_autoincrement]" value="1" class="form-control"></td><td width="13%"><select id="attributes['+x+'][attribute_inputtype][key]" name="attributes['+x+'][attribute_inputtype][key]" class="form-control" onchange="myFunction2(this,'+totalValue+','+x+')" ><option value="" selected="selected">---<option value="UUID">UUID</option><option value="REFERENCE_KEY">REFERENCE KEY</option><option value="REFERENCE_KEY_UUID">REFERENCE KEY & UUID</option><option value="FOREIGN_KEY">FOREIGN KEY</option><option value="EMAIL">EMAIL</option><option value="PASSWORD">PASSWORD</option><option value="NUMBER">NUMBER</option><option value="CONTACT">CONTACT</option><option value="FILE">FILE</option><option value="BOOLEAN">BOOLEAN</option><option value="HIDE">HIDE IN RESPONSE</option><option value="CURRENT_DATE">CURRENT DATE</option><option value="CURRENT_DATETIME">CURRENT DATETIME</option><option value="CURRENT_TIMESTAMP">CURRENT TIMESTAMP</option></select><div id='+totalValue+'></div></td><td width="4%" style="text-align:center"><a href="#" style="background-color:#000000;color:white;" class="remove_field_{{$table->uuid}} btn btn-default"><i class="fa fa-trash-o"></i></a></td></tr>'); //add input box
              }
            });

            jQuery(wrapper).on("click",".remove_field_{{$table->uuid}}", function(e){ //user click on remove text
              if(x==1) {
                alert('There must be single attribute in a table!');
              } else {
                e.preventDefault(); $(this).parent().parent().remove(); x--;
              }
            })
          });
          </script>
          <!-- End Of Add New Textarea For Add -->

          <!-- Insert Attributes -->
          <script>
          $(document).ready(function()
          {
            $('#insert_post_{{$table->uuid}}').on('submit', function(event)
            {
              event.preventDefault();
              $.ajax({
                url: "{{ route('attributes.create') }}",
                method:"POST",
                data:new FormData(this),
                contentType:false,
                cache:false,
                processData:false,
                success: function(data){
                  $('#result_{{$table->uuid}}').fadeIn().html("<i class='fa fa-check-circle'></i> "+ data);
                  setTimeout(function() {
                      $('#result_{{$table->uuid}}').fadeOut('fast');
                  }, 3000);
                }
              })
            });
          });
          </script>
          <!-- End Of Insert Attributes -->

        </div>
      </div>
    </form>
    <?php $tableCount = $tableCount+1; ?>
  @endforeach

</div>
<!-- End Of Container -->

<!-- Add/Edit New Tables Modal -->
<div class="modal fade" id="add_edit_tables">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="card-header text-center" id="add_edit_tables">
          &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
          Add Tables
          &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        </h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>

      <!-- Start Modal Body -->
      <div class="modal-body">

        <!-- Form -->
        <form method="POST" action="{{ route('tables.create') }}">
        @csrf

          <!-- Form Group -->
          <div class="form-group form-row">
            <div class="col-md-12">

              <!-- project uuid's default value -->
              <input id="project_uuid" type="text" name="project_uuid" value="{{ $project->uuid }}" style="display:none;">
              <label for="name"><b style="color:red;">*</b> Tables</label>

              <!-- Start Wrapper -->
              <div id="input_fields_wrap">

                <!-- New Tables -->
                <div>
                  <input id="table_name[0]" type="text" class="form-control" name="table_name[0]" style="width:80%;float:left;" required autofocus/>
                </div>
                <!-- End Of New Tables -->

              </div>
              <!-- End Of Wrapper -->

            </div>
          </div>
          <!-- End Of Form Group -->

          <!-- Add / Submit -->
          <div class="form-group" style="text-align:center;">
            <button id="add_field_button" class="btn btn-default" style="background-color:#000000;color:white;"><i class="fa fa-plus"></i></button>
            <button type="submit" class="btn btn-primary" style="background-color:#000000;color:white;">Submit</button>
            <button class="btn btn-primary" data-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
          <!-- End Of Add / Submit -->

        </form>
        <!-- End Of Form -->

      </div>
      <!-- End Of Modal Body -->

      <!-- Add New Textarea For Add -->
      <script type="text/javascript">
      jQuery(document).ready(function() {
        // Input Fields
        var max_fields      = 30; //maximum input boxes allowed
        var wrapper   		= $("#input_fields_wrap"); //Fields wrapper
        var add_button      = $("#add_field_button"); //Add button ID

        // Add Text Box
        var x = 0; //initlal text box count
        jQuery(add_button).click(function(e){ //on add input button click
          e.preventDefault();
          if(x < max_fields){ //max input box allowed
            x++; //text box increment

            $(wrapper).append('<div><input id="table_name['+x+']" type="text" class="form-control" name="table_name['+x+']" style="width:80%;float:left;" required autofocus/><a href="#" style="background-color:#000000;color:white;float:right;margin-top:4px;" class="remove_field btn btn-default"><i class="fa fa-trash-o"></i></a></div>'); //add input box
          }
        });

        // Remove Text Box
        jQuery(wrapper).on("click",".remove_field", function(e){ //user click on remove text
          e.preventDefault(); $(this).parent('div').remove(); x--;
        })

      });
      </script>
      <!-- End Of Add New Textarea For Add -->

    </div>
  </div>
</div>
<!-- End Of Add/Edit New Tables Modal -->

<!-- Showing Previous & Next Page Based On Project-->

<!-- PHP (CODEIGNITER) - PROJECT -->
@if($project->framework === "CODEIGNITER")
<!-- Redirect To Codeigniter Generate Page -->
<div class="form-group" style="text-align:center;">
  <a href="/databases/{{$project->uuid}}" type="button" class="btn btn-primary" style="background-color:#000000;color:white;"><i class="fa fa-arrow-circle-left"></i> Previous</a>
  @if(count($tables)>0)
    <a href="/framework/codeigniter/{{$project->uuid}}" type="button" class="btn btn-primary" style="background-color:#000000;color:white;">NEXT <i class="fa fa-arrow-circle-right"></i></a>
  @endif
</div>
<!-- End Of Redirect To Codeigniter Generate Page -->
@endif
<!-- PHP (CODEIGNITER) - PROJECT -->

<!-- PHP (LARAVEL) - PROJECT -->
@if($project->framework === "LARAVEL")
<!-- Redirect To Laravel Generate Page -->
<div class="form-group" style="text-align:center;">
  <a href="/databases/{{$project->uuid}}" type="button" class="btn btn-primary" style="background-color:#000000;color:white;"><i class="fa fa-arrow-circle-left"></i> Previous</a>
  @if(count($tables)>0)
    <a href="/framework/laravel/{{$project->uuid}}" type="button" class="btn btn-primary" style="background-color:#000000;color:white;">NEXT <i class="fa fa-arrow-circle-right"></i></a>
  @endif
</div>
<!-- End Of Redirect To Laravel Generate Page -->
@endif
<!-- PHP (LARAVEL) - PROJECT -->

<!-- NODE JS (EXPRESS) - PROJECT -->
@if($project->framework === "EXPRESS_JS_MYSQL")
<!-- Redirect To Node-js (express) Generate Page -->
<div class="form-group" style="text-align:center;">
  <a href="/databases/{{$project->uuid}}" type="button" class="btn btn-primary" style="background-color:#000000;color:white;"><i class="fa fa-arrow-circle-left"></i> Previous</a>
  @if(count($tables)>0)
    <a href="/framework/express/mysql/{{$project->uuid}}" type="button" class="btn btn-primary" style="background-color:#000000;color:white;">NEXT <i class="fa fa-arrow-circle-right"></i></a>
  @endif
</div>
<!-- Redirect To Node-js (express) Generate Page -->
@endif
<!-- NODE JS (EXPRESS) - PROJECT -->

<!-- End Of Showing Previous & Next Page Based On Project-->

@endsection