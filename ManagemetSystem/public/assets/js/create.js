const the_real_btn_image =  document.querySelector(".photo");
const the_fake_btn_iamge = document.querySelector(".btnImage");
const the_span_image = document.querySelector(".photoName");
the_fake_btn_iamge.addEventListener('click', function(ev)
{
    the_real_btn_image.click();
    ev.preventDefault();
});
the_real_btn_image.addEventListener('change',function()
{
    let span_text;
    const the_defult_value_image = "No File Chocin";
    span_text = the_real_btn_image.files[0].name;
    the_span_image.textContent = span_text || the_defult_value_image;
});

const the_real_btn_gcode =  document.querySelector(".gcode");
const the_fake_btn_gcode = document.querySelector(".btngcode");
const the_span_gcode = document.querySelector(".sigName");
the_fake_btn_gcode.addEventListener('click', function(ev)
{
    the_real_btn_gcode.click();
    ev.preventDefault();
});
the_real_btn_gcode.addEventListener('change',function()
{
    let span_text;
    const the_defult_value_gcode = "No File Chocin";
    span_text = the_real_btn_gcode.files[0].name;
    the_span_gcode.textContent = span_text || the_defult_value_gcode;
});


