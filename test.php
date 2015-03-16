<?php

function prepareJSON($input) {
    
    //This will convert ASCII/ISO-8859-1 to UTF-8.
    //Be careful with the third parameter (encoding detect list), because
    //if set wrong, some input encodings will get garbled (including UTF-8!)
    $input = mb_convert_encoding($input, 'UTF-8', 'ASCII,UTF-8,ISO-8859-1');
    
    //Remove UTF-8 BOM if present, json_decode() does not like it.
    if(substr($input, 0, 3) == pack("CCC", 0xEF, 0xBB, 0xBF))
        $input = substr($input, 3);
    
    return $input;
}

// $xml = file_get_contents($url)
// $profiel = new SimpleXMLElement($xml);

//var_dump(json_decode($json, true));

class Comment {
    public $message = "";
    public $user = "";
}

class Response {
    public $comments = array();
}

if (isset($_POST['command'])) {
    if ($_POST['command'] == "Echo")
    {
        $request = json_decode(prepareJSON($_POST['data']));
        if (is_null($request)) {
            echo "Failed to parse json";
        } else {
            echo json_encode($request);
        }
    } else {
        $response = new Response();
        for($i = 1; $i < 4; $i++)
        {
            $cmt = new Comment;
            $cmt->message = "This is comment number $i";
            $cmt->user = "User$i";
            array_push($response->comments, $cmt);
        }
    
        echo json_encode($response);
    }
} else {
?>
<!DOCTYPE html>
<html> 
	<head> 
		<title>Test</title> 
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/south-street/jquery-ui.css" type="text/css" rel="Stylesheet" />		
		<style> 
		@media all {
		}	
		</style> 
	</head> 
	<body> 
	<table id=results> 
	</table>
	<a href="#" id="testbutton">Get JSON Data</a>
	<script id="commenttemplate" type="text/template">
    	<tr><td>{{user}}</td><td>{{comment}}</td></tr>
	</script>	
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/jquery-ui.min.js"></script>
    <script src="http://ajax.cdnjs.com/ajax/libs/json2/20110223/json2.js"></script>
    <script>
        $(document).ready(function(){
            $('#testbutton').live('click', function(){
                var jsonText = JSON.stringify({
                    'comments' : [
                        {
                            'message': "This is comment 1",
                            'user': "User1"
                        },
                        {
                            'message': "This is comment 1",
                            'user': "User1"
                        },
                        {
                            'message': "This is comment 1",
                            'user': "User1"
                        }
                    ]
                });
                $.ajax({
                    'url': 'test.php',
                    'type': 'POST',
                    'data': {
                        'command': "Echo",
                        'data': jsonText
                    },
                    'dataType': "json",
                    'success': function(data) {
                        for(var cmt in data.comments) {
                            $('#results').append(
                                $('#commenttemplate').html(
                                ).replace('{{user}}', data.comments[cmt].user
                                ).replace('{{comment}}', data.comments[cmt].message
                                )
                            );
                        }
                    },
                    'error': function(e) {
                        $('#results').html(e.message);
                    }
                });
//                $('#results').html("Click works");
            });
        });
    </script>
    </body>
</html>
<?php
}
?>
