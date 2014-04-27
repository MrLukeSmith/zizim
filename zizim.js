$(function(){
  
  $("#resetForm").click(function(){
    resetForm();
  });


  $("h2.switch").click(function(){
    $("h2.switch, .custom_alias").toggle(); 
    $("html, body").animate({ scrollTop: $('.custom_alias').offset().top }, 1000);
  });

  $("#generate_url").click(function( event ){
    event.preventDefault();
    validateURL( $("input[name=URL]").val() );
  });

});

function validateURL( url ){

  $(".error").html("").hide();

  $.get( "backend.php?action=validate&url="+url, function( data ) {

    var validateResult = $.parseJSON( data );

    switch (validateResult.valid){
      case true:
        generateURL( validateResult.url );
        break;
      case false:
        displayError("Invalid URL. Please check and try again.");
        break;
    }

  });

}

function aliasCheck(){

  var alias = $("input[name=alias]").val();

  if (alias){

    var response;

    // // Check the alias doesn't exist already, if applicable. 
    
    $.ajax({
      url: "backend.php?action=aliascheck&alias="+alias,
      async: false
    }).done(function( data ) {
      
      var aliasResult = $.parseJSON( data );

      if ( aliasResult.valid == false ) {

        if ( aliasResult.reason ){
          switch ( aliasResult.reason ){
            case "alphanumeric":
              displayError("Sorry, you can only have alphanumeric characters in an alias. 0-9 // a-z");
              break;
          }
        } else {
          displayError("Sorry, that alias has already been used. Please try a different one.");
        }
      
      }

      response = aliasResult.valid;

    });

    return response;

  } else {

    return true;

  }

}

function generateURL( url ){

  if ( aliasCheck() ){

    $("#shorten_form, .loader").toggle();
    // Hides the form. Shows the loader. 

    if ($("input[name=alias]").val() != ""){
      alias = "&alias=" + $("input[name=alias]").val();
    } else {
      alias = "";
    }

    $.ajax({
      url: "backend.php?action=generate"+alias,
      async: false
    }).done(function( data ) {
      
      var urlData = $.parseJSON( data );

      if (urlData.shortened){

        $(".loader, .result").toggle();
        $("span[class=url]").html( urlData.shortened );

      } else {

        $("#shorten_form, .loader").toggle();
        $("input[name=url]").val(url);
        $("input[name=alias]").val(alias);
        displayError("Sorry, something went wrong. Please try again.");

      }

    });

  }

}

function displayError ( error ){
  $(".error").html( error ).css("display","block");
}

function resetForm(){
  $(".loader, .result").hide();
  $('#shorten_form')[0].reset();
  $("#shorten_form").show();
}