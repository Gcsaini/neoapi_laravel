<!DOCTYPE html>
<html>
    <head>
        <title>
            Nearest Earth object
        </title>
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

        <link href= "http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" 
        rel="Stylesheet"
        type="text/css" />
    
      <link href= "{{ asset('asset/style.css')}}" 
          rel="Stylesheet"
          type="text/css" />

      <script type="text/javascript" 
          src="http://code.jquery.com/jquery-1.7.2.min.js">
      </script>
    
      <script type="text/javascript" 
          src="http://code.jquery.com/ui/1.10.4/jquery-ui.js">
      </script>

    </head>
<body>

  <div class="container-fluid">
    <div class="row">
        <h1 class="text-center mb-4 mt-4">Find the Nearest object</h1>
        <div class="col-md-8 offset-md-2">
       

            <!-- Form code begins -->
            <form method="post" action="{{route('submit')}}">
              @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <!-- Date input -->
                            <label class="control-label" for="date" >Start Date</label>
                            <input class="form-control" name="startdate" id="txtdate"  placeholder="MM/DD/YYY" type="date" value="@if(isset($sdate)){{$sdate}}@endif"/>
                            @error('startdate')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <!-- Date input -->
                            <label class="control-label" for="date">End Date</label>
                            <input class="form-control" id="date" name="enddate" placeholder="MM/DD/YYY" type="date" value="@if(isset($sdate)){{$edate}}@endif"/>
                            @error('enddate')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                        
                    </div>
                </div>
               
                <div class="form-group text-center">
                    <span class="text-danger">
                      @if($msg=Session::get('rangeerror'))
                        {{$msg}}

                      @endif

                    </span>
                     
                </div>

                <div class="form-group text-center">
                    <!-- Submit button -->
                    <button class="btn btn-primary mt-4 sub-btn" name="submit" type="submit">Submit</button>
                </div>
            </form>
            <!-- Form code ends -->

        </div>
    </div>
</div>
</br>
</br>
<?php 

if(isset($total)){

?>
<div class="container">

            <div class="row">
                <h4 class="text-center mb-4 mt-4">Total Astroids found : {{$total}}
                 </h4>
            
                <div class="col-md-4 mt-2 mb-4">
                    <div class="box-details">
                            <div class="details">

                                <span class="title">Speed</span>
                                </br>
                                <span class="double">
                                  @if(isset($max))
                                  {{$max}}
                                 @endif</span>
                                </br>
                                <span>KM/S</span>
                                </br>
                                <span>ID: 23123123</span>

                            </div>
                            </br>
                            <div class="footer">
                                <span>Fastest Astroid</span>
                            </div>
                    </div>

                </div>
                <div class="col-md-4 mt-2 mb-4">
                    <div class="box-details-2">
                        <div class="details">

                            <span class="title">Distance</span>
                            </br>
                            <span class="double">@if(isset($min))
                              {{$min}}
                             @endif</span>
                            </br>
                            <span>KM/S</span>
                            </br>
                            <span>ID: 12213</span>

                        </div>
                        
                        <div class="footer">
                            <span>Closest Asteroid</span>
                        </div>
                    </div>
                        
                </div>
                <div class="col-md-4 mt-2 mb-4">
                    <div class="box-details-3">
                        <div class="details">

                            <span class="title">Size</span>
                            </br>
                            <span class="double">@if(isset($avg))
                              {{$avg}}
                             @endif</span>
                            </br>
                            <span>KM</span>
                           

                        </div>
                        
                        <div class="footer">
                            <span>Average Size of the Asteroids </span>
                        </div>
                    </div>
                        
                </div> 
            </div>
        <div class="col-md-12 mt-4">
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>

        </div>
   
</div>
</br>
</br>
<?php
}
?>
</body>

<!-- JavaScript Bundle with Popper -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script>
  window.onload = function() {

      var chart = new CanvasJS.Chart("chartContainer", {
          animationEnabled: true,
          theme: "light2", // "light1", "light2", "dark1", "dark2"
          title: {
              text: "Number of Astroid objects per day"
          },
          axisY: {
              title: "Number of Astroids"
          },
          data: [{
              type: "column",
              dataPoints: <?php if(isset($arr)) echo json_encode($arr); ?>
          }]
      });
      chart.render();

  }
  </script>
</html>