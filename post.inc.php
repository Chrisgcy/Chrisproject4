<style>
.col-centered {
	float:none;
	margin: 0 auto;
}

textarea {
    resize: none;
}

#locationField, #controls {
position: relative;
width: 100%;
margin: -1 0 5 0;
display:none;
}
#autocomplete {
position: absolute;
top: 0px;
left: 0px;
width: 100%;
}
.label {
    text-align: right;
    font-weight: bold;
width: 100px;
color: #303030;
}
#address {
border: 1px solid #000090;
background-color: #f0f0ff;
width: 480px;
padding-right: 2px;
}
#address td {
font-size: 10pt;
}
.field {
width: 99%;
}
.slimField {
width: 80px;
}
.wideField {
width: 200px;
}
#locationField {
height: 20px;
}
</style>
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>


<form id="fileupload" action="fileuploadhandler.php" method="POST" enctype="multipart/form-data">
	<div class="row fileupload-buttonbar">
		<div class="col-lg-12">

			<!-- The fileinput-button span is used to style the file input field as button -->
			<span id="addfilebtn" class="btn btn-info fileinput-button">
				<i class="glyphicon glyphicon-plus"></i>
				<span>Add files...</span>
				<input type="file" name="files[]" multiple>
				<!-- The file input field used as target for the file upload widget -->
				<!--<input id="fileupload" type="file" name="files[]" multiple>-->
			</span>

            <!-- Activity Button -->
            <div class="dropdown btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
				    <span>&nbsp</span>
				    <i class="glyphicon glyphicon-tags"></i>
				    <span>&nbsp</span>
				    <!--<span>Activity</span>
                    <span class="caret"></span>-->
                </button>
                <ul class="dropdown-menu" role="menu">
<?php
    include("db_connect.inc.php");
    $get_act_sql = "select * from activity";
    $result = mysql_query($get_act_sql);
    if ($result) {
        $act_li_format = "<li class='act-item' id='actli%d'><a href='#'>%s</a></li>";
        while ($act = mysql_fetch_assoc($result)) {
            $act_li = sprintf($act_li_format, $act["actid"], $act["aname"]);
            echo $act_li;
            //error_log($act_li);
        }
    } else {
        error_log(mysql_error());
        error_log("get_act_sql err: ".$get_act_sql); 
    }
    mysql_close($connect);
?>
                </ul>
            </div>

            <!-- Location Button -->
			<button type="button" class="btn btn-info add-loc-btn">
				<span>&nbsp</span>
				<i class="glyphicon glyphicon-map-marker"></i>
				<span>&nbsp</span>
			</button>

            <!-- Privacy Button -->
            <div class="dropdown btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span>&nbsp</span>
                    <i class="glyphicon glyphicon-eye-open"></i>
                    <span>&nbsp</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li class='dv-item' id='dvfriend'><a href='#'>Friends</a></li>
                    <li class='dv-item' id='dvfof'><a href='#'>FOFs</a></li>
                    <li class='dv-item' id='dveveryone'><a href='#'>Everyone</a></li>
                </ul>
                <input type='hidden' id='dvinput' name='dv' value='friend'></input>
            </div>

            <!-- Post Button -->
			<button type="submit" id="fileupload_submit" class="btn btn-primary start">
				<i class="glyphicon glyphicon-upload"></i>
				<span>Post&nbsp;&nbsp;</span>
			</button>
		</div>
	</div>

    <!-- Note Input -->
	<textarea id="micropost_content" name="micropost[content]" placeholder="Give comment ..." style="width:100%; height: 50px;"></textarea>

    <!-- Location Input -->
    <div id="locationField">
        <input id="autocomplete" placeholder="Enter your address" onFocus="geolocate()" type="text"></input>
        <input type='hidden' id='loc_id' name='loc_id' value=''></input>
        <input type='hidden' id='loc_name' name='loc_name' value=''></input>
        <input type='hidden' id='loc_lat' name='loc_lat' value=''></input>
        <input type='hidden' id='loc_lon' name='loc_lon' value=''></input>
    </div>

    <!-- Show Activity Here -->
    <div id="tag_holder" style="margin-top: 10px; margin-bottom:10px;"></div>
    
	<!-- The container for the uploaded files 
	<div id="files" class="files"></div> -->
	
	<!-- The global progress bar -->
	<div id="progress" class="progress" style="display:none">
		<div class="progress-bar progress-bar-success"></div>
	</div>

	<!-- The table listing the files available for upload/download -->
	<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>

</form>

<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
	<div class="slides"></div>
	<h3 class="title"></h3>
	<a class="prev">‹</a>
	<a class="next">›</a>
	<a class="close">×</a>
	<a class="play-pause"></a>
	<ol class="indicator"></ol>
</div>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<tr class="template-upload fade">
	<td>
		<span class="preview"></span>
	</td>
	<td>
		<p class="name">{%=file.name%}</p>
		<strong class="error text-danger"></strong>
	</td>
	<td>
		<p class="size">Processing...</p>
		<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
			<div class="progress-bar progress-bar-success" style="width:0%;">
			</div>
		</div>
	</td>
	<td>
	{% if (!i && !o.options.autoUpload) { %}
		<button class="btn btn-primary start" disabled style="display:none">
			<i class="glyphicon glyphicon-upload"></i>
			<span>Start</span>
		</button>
	{% } %}
	</td>
</tr>
{% } %}
</script>

<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
	<tr class="template-download fade">
		<td>
			<span class="preview">
			{% if (file.thumbnailUrl) { %}
				<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
			{% } %}
			</span>
		</td>
		<td>
			<p class="name">
			{% if (file.url) { %}
				<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
			{% } else { %}
				<span>{%=file.name%}</span>
			{% } %}
			</p>
			{% if (file.error) { %}
			<div><span class="label label-danger">Error</span> {%=file.error%}</div>
			{% } %}
		</td>
		<td>
			<span class="size">{%=o.formatFileSize(file.size)%}</span>
		</td>
		<td>
		{% if (file.deleteUrl) { %}
			<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
				<i class="glyphicon glyphicon-trash"></i>
				<span>Delete</span>
			</button>
			<input type="checkbox" name="delete" value="1" class="toggle">
		{% } else { %}
			<button class="btn btn-warning cancel">
				<i class="glyphicon glyphicon-ban-circle"></i>
				<span>Cancel</span>
			</button>
		{% } %}
		</td>
	</tr>
{% } %}
</script>


<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> -->
<!-- blueimp Gallery script -->
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="https://rawgit.com/blueimp/jQuery-File-Upload/master/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="fileupload.js"></script>
<script>
$(".act-item").click(function() {
    var actid = $(this).attr('id').substring(5),
        actname = $(this).find("a").text();
    var act_input_html = "<input type='hidden' name='activity[]' value=" + actid + ">",
        tag_html = "<span class='label label-default' style='margin-right:5px'>" + actname + "</span>"
    $("#fileupload").append(act_input_html);
    $("#tag_holder").append(tag_html);
});


$(".add-loc-btn").click(function() {
    $("#locationField").css("display", "block");
});

$(".dv-item").click(function() {
    var visibility = $(this).attr('id').substring(2);
    $("#dvinput").val(visibility);
    //alert(visibility);
});





// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

var placeSearch, autocomplete;
var componentForm = {
street_number: 'short_name',
route: 'long_name',
locality: 'long_name',
administrative_area_level_1: 'short_name',
country: 'long_name',
postal_code: 'short_name'
};

function initialize() {
    // Create the autocomplete object, restricting the search
    // to geographical location types.
    autocomplete = new google.maps.places.Autocomplete(
                                                       /** @type {HTMLInputElement} */(document.getElementById('autocomplete')),
                                                       { types: ['geocode'] });
    // When the user selects an address from the dropdown,
    // populate the address fields in the form.
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
                                  fillInAddress();
                                  });
}

// [START region_fillform]
function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
    //alert(place.geometry.location.A);

    //var id_html = "<input type='hidden' id=='loc_id' name='loc_id' value='" + place.id + "'></input>",
    //    name_html = "<input type='hidden' id=='loc_name' name='loc_name' value='" + place.name + "'></input>",
    //    lat_html = "<input type='hidden' id=='loc_lat' name='loc_lat' value='" + place.geometry.location[0] + "'></input>",
    //    lon_html = "<input type='hidden' id=='loc_lon' name='loc_lon' value='" + place.geometry.location[1] + "'></input>";
    $("#loc_id").val(place.id);
    $("#loc_name").val(place.name);
    $("#loc_lat").val(place.geometry.location.k);
    $("#loc_lon").val(place.geometry.location.A);
    
    //for (var component in componentForm) {
    //    document.getElementById(component).value = '';
    //    document.getElementById(component).disabled = false;
    //}
    
    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    //for (var i = 0; i < place.address_components.length; i++) {
    //    var addressType = place.address_components[i].types[0];
    //    if (componentForm[addressType]) {
    //        var val = place.address_components[i][componentForm[addressType]];
    //        document.getElementById(addressType).value = val;
    //    }
    //}
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
                                                 var geolocation = new google.maps.LatLng(
                                                                                          position.coords.latitude, position.coords.longitude);
                                                 autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,
                                                                                                     geolocation));
                                                 });
    }
}
// [END region_geolocation]

google.maps.event.addDomListener(window, 'load', initialize);

</script>

