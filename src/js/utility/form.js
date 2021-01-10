{
  const init = () =>{
    console.log('form init');
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
  }
  init();
}
