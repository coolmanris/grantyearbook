<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<title>Plupload - Custom example</title>

<!-- production -->
    <script type="text/javascript" src="/plupload-2.0.0/js/plupload.full.min.js"></script>


<!-- debug
<script type="text/javascript" src="../js/moxie.js"></script>
<script type="text/javascript" src="../js/plupload.dev.js"></script>
-->

</head>

<h1>File Upload:</h1>
<p>Files will be overwritten if they already exist</p>
<div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
<br />

<div id="container">
    <script>
        var verify;
    if (verify === true) {document.write('<a id="pickfiles" href="javascript:;">[Select files]</a> <a id="uploadfiles" href="javascript:;">[Upload files]</a>')
    }
    </script>
</div>

<br />
<pre id="console"></pre>


<script type="text/javascript">
// Custom example logic

var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'pickfiles', // you can pass in id...
        container: document.getElementById('container'), // ... or DOM Element itself
        url : 'upload.php',
        flash_swf_url : '/plupload-2.0.0/js/Moxie.swf',
        silverlight_xap_url : '/plupload-2.0.0/js/Moxie.xap',
        chunk_size : '1mb',
        max_file_size : '10gb',

        init: {
                PostInit: function() {
                        document.getElementById('filelist').innerHTML = '';

                        document.getElementById('uploadfiles').onclick = function() {
                                uploader.start();
                                return false;
                        };
                },

                FilesAdded: function(up, files) {
                        plupload.each(files, function(file) {
                                document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                        });
                },

                UploadProgress: function(up, file) {
                        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                },

                Error: function(up, err) {
                        document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
                }
        }
});

uploader.init();

</script>


</body>
</html>