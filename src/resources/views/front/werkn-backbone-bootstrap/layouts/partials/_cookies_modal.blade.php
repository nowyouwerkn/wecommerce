@php
  $popup = Nowyouwerkn\WeCommerce\Models\Popup::where('is_active', true)->first();
@endphp

    <style type="text/css">
      .overlay-cookie {
        position: fixed;
        width: 25%;
        background: black;
        color: white;
        border: solid 1px grey;
        padding: 20px; 
        bottom: 0;
        left: 0;
        z-index: 99;
      }

      .close-div{
        text-align: right;
      }

      .close-cookie {
        color: white;
        border: none;
        background-color: transparent;
      }
    </style>

<div id="myDiv" class="overlay-cookie">
  <div class="close-div">
    <button class="close-cookie" onclick="document.getElementById('myDiv').style.display='none'" >X</button>
  </div>
<a class="fragment" href="http://google.com">
    <div>
    <img src ="http://placehold.it/116x116" alt="some description"/> 
    <h3>Cookies cookies</h3>
        <h4> Cookies </h4>
    <p class="text">
        Aqui mostrara un mensaje el cual pondra
    </p>
</div>
</a>
</div>

<script type="text/javascript">

   document.getElementById('close-cookie').onclick = function(){
    document.cookie = 'modal_shown=seen';
        document.cookie = 'cookies_shown=seen, max-age=7776000';
        this.parentNode.parentNode.parentNode
        .removeChild(this.parentNode.parentNode);
        return false;
    };

</script>
