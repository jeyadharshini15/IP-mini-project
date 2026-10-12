function validateRegister(f){
  if(f.password.value.length<6){alert('Password must be at least 6 characters.');return false;}
  if(f.password.value!==f.confirm.value){alert('Passwords do not match.');return false;}
  return true;
}
document.addEventListener('DOMContentLoaded',()=>{
  document.querySelectorAll('.card form button').forEach(b=>b.addEventListener('click',()=>{b.textContent='Added ✓';}));
});
