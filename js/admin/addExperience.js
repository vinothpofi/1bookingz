

/* experience supports */

function experienceDetailview(evt,catID,chk){
	var title = evt.value;
	//alert(chk);
	var pattern = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/; // fragment locater

	no_ajax =0;
    if(chk=='video_url') {
	  if(!pattern.test(title)) {
		$("#video_url").val("");
	    alert("Please enter a valid URL.");	
	    no_ajax=1;
	  } else {
	    no_ajax=0;
	  }
	}
	if(no_ajax==0){
		$.ajax({
			type:'post',
			url:baseURL+'site/experience/saveDetailPage',
			data:{'catID':catID,'title':title,'chk':chk},
			
			complete:function(){
				$('#imgmsg_'+catID).hide();
				$('#imgmsg_'+catID).show().text('Saved');
			}
		});
	}
}


function experirenceChangeOVerviewdesc(evt,catID){
	var title = evt.value;
		$.ajax({
			type:'post',
			url:baseURL+'site/experience/saveOverviewListDesc',
			data:{'catID':catID,'title':title},
			
			complete:function(){
				$('#imgmsg_'+catID).hide();
				$('#imgmsg_'+catID).show().text('Done').delay(800).text('');
			}
		});
}

function SiteDeleteExperienceImage(prdID,imgID){
	
		 $.ajax({
			type:'post',
			url:'site/experience/deleteProductImage',
			data:{prdID:prdID},
			dataType:'json',
			success:function(json){
				//alert(json);
				
				$('#imgmsg_'+prdID).hide();
				$('#imgmsg_'+prdID).show().text('Done').delay(800).text('');
				window.location.href = "experience_image/"+imgID;
				
				
			}
		}); 
}

function DeleteProductImage(prdID,Id){
	//alert("Product ID"+prdID+Id);
	//alert(baseURL+'admin/product/deleteProductImage');
		$.ajax({
			type:'post',
			url:baseURL+'admin/experience/deleteProductImage',
			data:{'prdID':prdID},
			dataType:'json',
			success:function(json){
				 //alert(json.resultval);
				
				$('#img_'+prdID).hide();
				$('#img_'+prdID).show().text('Done').delay(800).text('');
				//window.location.href = baseURL+"admin/product/add_product_form/"+prdID;
				//window.location.hash;
				
			}
		});
}


function PriceInsert(evt,catID,chk){
	var title = evt.value;
	//alert(evt+catID+chk);
		$.ajax({
			type:'post',
			url:baseURL+'admin/experience/OtherDetailInsert',
			data:{'chk':chk,'catID':catID,'val':evt},
			dataType:'json',
			success:function(json){
				// alert(json.resultval);
				//$('#prdiii').val(json.resultval);
				$('#imgmsg_'+catID).hide();
				$('#imgmsg_'+catID).show().text('Done').delay(800).text('');
				//window.location.href = "admin/product/edit_product_form/"+json.resultval;
				window.location.hash;
				
			}
		});
}


function experienceDetailview_admin(evt,catID,chk){
	
	var title = evt.value;
	//alert(title);
	//alert(chk);
		$.ajax({
			type:'post',
			url:baseURL+'admin/experience/saveDetailPage',
			data:{'catID':catID,'title':title,'chk':chk},
			
			complete:function(){
				$('#imgmsg_'+catID).hide();
				$('#imgmsg_'+catID).show().text('Saved');
			}
		});
}

/* Admin Detail Page Save */
function experienceAdminDetailview(evt,catID,chk){
	//alert("Welcome"+evt.value);
	var title = evt.value;
	
	//alert(title+catID);
	if(catID==0) {
	
		$.ajax({
			type:'post',
			url:baseURL+'admin/experience/saveAdminDetailPage',
			data:{'title':title,'chk':chk,'catID':catID},
			dataType:'json',
			success:function(json){
				
				$('#prdiii').val(json.resultval);
				$('#imgmsg_'+catID).hide();
				$('#imgmsg_'+catID).show().text('Done').delay(800).text('');
				//window.location.href = "admin/product/edit_product_form/"+json.resultval;
				//alert(json.resultval);
				window.location.hash=json.resultval;
				
			}
		});
	}
	else {
	//window.location.hash = "admin/product/edit_product_form/"+catID;
	//alert("update successfully");


	window.location.hash;
	}
	
	
}


/* experience supports ends */