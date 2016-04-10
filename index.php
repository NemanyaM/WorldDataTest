<html>
    <head>
        
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">

        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>

        
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">                  
                    <div class="page-header">
                        <h1 class="text-center">
                            <strong>World DataBase Test</strong>
                        </h1>
                    </div> 
					<div class="clearfix"></div>					
					<div class="">
					  <label class="control-label" for="radios">Sorting</label>
					  <div class="">
					  <div class="radio">
						<label for="radio0">
						  <input type="radio" name="radios" id="radio0" value="client" checked="checked">
						  Client Side
						</label>
						</div>
					  <div class="radio">
						<label for="radio1">
						  <input type="radio" name="radios" id="radio1" value="server">
						  Server Side
						</label>
						</div>
					  </div>
					</div>	
					<div class="clearfix"></div>
					<hr>
                    <table id="world_data" class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th class="bg-success">
                                    Continet
                                </th>
                                <th class="bg-success">
                                    Region
                                </th>
                                <th class="bg-success">
                                    Countries
                                </th>
                                <th class="bg-success">
                                    Life Duration
                                </th>
                                <th class="bg-success">
                                    Population
                                </th>
                                <th class="bg-success">
                                    Cities
                                </th>
                                <th class="bg-success">
                                    Languages
                                </th>
                            </tr>
                        </thead>
                    </table>            
        </div>
        <script>
            $(document).ready(function () {
				var worldDataTable,
					worldDataTableColumns = [
								{								
									"data": "Continent"								   
								}, {									
									"data": "Region"																	   
								}, {									
									"data": "Countries"																	   
								}, {									
									"data": "LifeExpectancy",								
									"render": function (data, type, row) {
									    return parseFloat(data).toFixed(2);
								   }								   
								}, {									
									"data": "Population"									
								}, {									
									"data": "Cities"																		
								}, {
									"data": "Languages"
								}
							],
					initClientSideTable = function (){
						worldDataTable = $('#world_data').DataTable({
							"paging": false,
							"info" : false,
							"searching" : false,
							"ajax": "get_world_data.php",
							"columns": worldDataTableColumns
						});		
								
					},
					initServerSideTable = function (){
						worldDataTable = $('#world_data').DataTable({
							"paging": false,
							"info" : false,
							"searching" : false,
							"serverSide" : true,
							"ajax": {
								"url": "get_world_data.php",
								"type" : "POST"
								
							},
							"fnServerData" : function ( source, data, callback ) {                           
									$.ajax( {
										"dataType" : 'json',
										"type" : "POST",
										"url": "get_world_data.php",
										"data" : { "data": data },
										"success" : function(json) {
											  callback(json);
										}
									});      
								},
							"columns": worldDataTableColumns
						});		
								
					};
				initClientSideTable();
				$('#radio1').on('click', function(){					
					worldDataTable.destroy();
					initServerSideTable();	
				});
				$('#radio0').on('click', function(){					
					worldDataTable.destroy();
					initClientSideTable();
				});			
                
            });
        </script>
    </body>
</html>