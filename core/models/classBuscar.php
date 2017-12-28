<?php
	class Buscar{
		private $prod;
		private $valor;
		private $db;
		private $mod;
		private $art;
		private $alma;
		public function __construct(){
			$this->db=new Conexion();
		}
		public function modelo3er(){
			$this->prod=$_POST['prod'];
			$sql=$this->db->query("SELECT id_modelo, modelo, precio FROM modelo WHERE id_producto=$this->prod;");
			?>
				<option value="">Seleccione</option>
			<?php
			while($data=$this->db->recorrer($sql)){
				$precio=number_format($data[2], 2, ',', '.');
				?>
					<option value="<?php echo $data[0];?>"><?php echo $data[1]." Precio: ".$precio." Bs.";?></option>
				<?php
			}
		}
		public function precio3er(){
			$this->art=$_POST['art'];
			$this->mod=$_POST['mod'];
			$this->alma=$_POST['alma'];
			$sql=$this->db->query("SELECT m.precio, e.unidades FROM existencia e INNER JOIN modelo m ON e.id_modelo=m.id_modelo WHERE e.id_modelo=$this->mod AND e.id_almacenadora=$this->alma LIMIT 1;");
			$data=$this->db->recorrer($sql);
			?>
				<script>
					var formatNumber={
 						separador: ".", // separador para los miles
 						sepDecimal: ',', // separador para los decimales
 						formatear:function (num){
	 						num+='';
							var splitStr=num.split('.');
							var splitLeft=splitStr[0];
							var splitRight=splitStr.length > 1 ? this.sepDecimal+splitStr[1] : '';
							var regx=/(\d+)(\d{3})/;
							while(regx.test(splitLeft)){
							 	splitLeft=splitLeft.replace(regx, '$1'+this.separador+'$2');
							}
 							return this.simbol + splitLeft+splitRight;
 						},
 						new:function(num, simbol){
 							this.simbol=simbol ||'';
 							return this.formatear(num);
 						}
					}
					function iva(){
				        var canpro=$("#productos").val();
				        var total=0;
				        for(x=1;x<=canpro;x++){
				            var canti=$("#cant"+x).val();
				            if(canti!=""){
				                var subtotal=$("#sub"+x).val();
				            }else{
				                subtotal=0;
				            }
				            total=total+Number(subtotal);
				        }
				        iva_oculto=total*0.12;
				        iva_oculto=iva_oculto.toFixed(2);
				        iva=iva_oculto.replace(".", ",");
				        iva=formatNumber.new(iva_oculto);
				        document.getElementById("pretotal").value=total+" Bs.";
				        document.getElementById("iva").value=iva+" Bs.";
				        document.getElementById("iva_oculto").value=iva_oculto;
				    }
				    function unidad(){
				        var canpro=$("#productos").val();
				        var total=0;
				        for(x=1;x<=canpro;x++){
				            var prod=$("#prod"+x).val();
				            if(prod!=""){
				                var subtotal=$("#cant"+x).val();
				            }else{
				                subtotal=0;
				            }
				            total=Number(total)+Number(subtotal);
				            document.getElementById("uni_total").value=total;
				        }
				    }
					function total(){
				        var canpro=$("#productos").val();
				        var iva_oculto=$("#iva_oculto").val();
				        var total=0;
				        for(x=1;x<=canpro;x++){
				            var canti=$("#cant"+x).val();
				            if(canti!=""){
				                var subtotal=$("#sub"+x).val();
				            }else{
				                subtotal=0;
				            }
				            total=Number(total)+Number(subtotal);
				        }
				        //total=total+Number(iva_oculto);
				        total=total.toFixed(2);
				        total1=total.replace(".", ",");
				        total1=formatNumber.new(total1);
				        document.getElementById("subtot").value=total1+" Bs.";
				        document.getElementById("subtotal_num").value=total;
				        document.getElementById("total").value=total1+" Bs.";
				        document.getElementById("total_num").value=total;
				    }
					$("#cant"+<?php echo $this->art?>).change(function(){
				        var cant=$("#cant"+<?php echo $this->art?>).val();
				        var precio=$("#precio"+<?php echo $this->art?>).val();
				        var unidades=$("#unidad"+<?php echo $this->art?>).val();
				        var subtotal=0;
				        var uni=$("uni_total");
				        cant=Number(cant);
				        unidades=Number(unidades);
				        precio=Number(precio);
				        if(cant==""){
				        	cant=0;
				        }
				        if(cant<=unidades){
				            sub=precio*cant;
				            sub=sub.toFixed(2);
				            subt=sub.replace(".", ",");
				            subt=formatNumber.new(subt);	
				            document.getElementById("subtotal"+<?php echo $this->art;?>).value=subt+" Bs.";
				            document.getElementById("sub"+<?php echo $this->art;?>).value=sub;
				            //iva();
				            unidad();
				            total();
				        }else{
				            swal(
					            {title:'La cantidad de productos ingresado es mayor a la que hay en existencia!',
					            type:'warning',
					            confirmButtonText:'Cerrar'}
					        );
				            document.getElementById("cant"+<?php echo $this->art?>).value="";
				        }
				    });
				    $("#subtot").click(function(){
				    	var canpro=$("#productos").val();
				        var iva_oculto=$("#iva_oculto").val();
				        var total=0;
				        for(x=1;x<=canpro;x++){
				            var canti=$("#cant"+x).val();
				            if(canti!=""){
				                var subtotal=$("#sub"+x).val();
				            }else{
				                subtotal=0;
				            }
				            total=Number(total)+Number(subtotal);
				        }
				        //total=total+Number(iva_oculto);
				        total=total.toFixed(2);
				        total1=total.replace(".", ",");
				        total1=formatNumber.new(total1);
				        document.getElementById("subtot").value=total1+" Bs.";
				        document.getElementById("subtotal_num").value=total;
				        document.getElementById("total").value=total1+" Bs.";
				        document.getElementById("total_num").value=total;
				    });
				    $("#descuento2").click(function(){
				    	var desc=$("#descuento").val();
				    	var sub=$("#subtotal_num").val();
				    	var descuento=0;
				    	descuento=Number(sub)*Number(desc)/100;
				    	total=Number(sub)-descuento;
				    	descuento=descuento.toFixed(2);
				        descu=descuento.replace(".", ",");
				        descu=formatNumber.new(descu);
				        total=total.toFixed(2);
				        total1=total.replace(".", ",");
				        total1=formatNumber.new(total1);	
				        document.getElementById("descuento2").value=descu+" Bs.";
				        document.getElementById("desc_num").value=descuento;
				        document.getElementById("total").value=total1+" Bs.";
				        document.getElementById("total_num").value=total;
				    });
				    $("#descuento").change(function(){
				    	var desc=$("#descuento").val();
				    	var sub=$("#subtotal_num").val();
				    	var descuento=0;
				    	descuento=Number(sub)*Number(desc)/100;
				    	total=Number(sub)-descuento;
				    	descuento=descuento.toFixed(2);
				        descu=descuento.replace(".", ",");
				        descu=formatNumber.new(descu);
				        total=total.toFixed(2);
				        total1=total.replace(".", ",");
				        total1=formatNumber.new(total1);	
				        document.getElementById("descuento2").value=descu+" Bs.";
				        document.getElementById("desc_num").value=descuento;
				        document.getElementById("total").value=total1+" Bs.";
				        document.getElementById("total_num").value=total;
				    });
				</script>
		    	<input type="text" class="form-control" id="cant<?php echo $this->art;?>" name="cant<?php echo $this->art;?>" onkeypress="return solonumeros(event)">
		    	<input type="hidden" id="precio<?php echo $this->art;?>" value="<?php echo $data[0];?>">
		    	<input type="hidden" id="unidad<?php echo $this->art;?>" value="<?php echo $data[1];?>">
				<div>Disponible: <?php echo $data[1];?></div>
			<?php
		}
		public function modelo4to(){
			$this->prod=$_POST['prod'];
			$sql=$this->db->query("SELECT id_modelo, modelo, precio FROM modelo_4to WHERE id_producto=$this->prod;");
			?>
				<option value="">Seleccione</option>
			<?php
			while($data=$this->db->recorrer($sql)){
				$precio=number_format($data[2], 2, ',', '.');
				?>
					<option value="<?php echo $data[0];?>"><?php echo $data[1]." Precio: ".$precio." Bs.";?></option>
				<?php
			}
		}
		public function precio4to(){
			$this->art=$_POST['art'];
			$this->mod=$_POST['mod'];
			$this->alma=$_POST['alma'];
			$sql=$this->db->query("SELECT m.precio, e.unidades FROM existencia_4to e INNER JOIN modelo_4to m ON e.id_modelo=m.id_modelo WHERE e.id_modelo=$this->mod AND e.id_almacenadora=$this->alma LIMIT 1;");
			$data=$this->db->recorrer($sql);
			?>
				<script>
					var formatNumber={
 						separador: ".", // separador para los miles
 						sepDecimal: ',', // separador para los decimales
 						formatear:function (num){
	 						num+='';
							var splitStr=num.split('.');
							var splitLeft=splitStr[0];
							var splitRight=splitStr.length > 1 ? this.sepDecimal+splitStr[1] : '';
							var regx=/(\d+)(\d{3})/;
							while(regx.test(splitLeft)){
							 	splitLeft=splitLeft.replace(regx, '$1'+this.separador+'$2');
							}
 							return this.simbol + splitLeft+splitRight;
 						},
 						new:function(num, simbol){
 							this.simbol=simbol ||'';
 							return this.formatear(num);
 						}
					}
					function iva(){
				        var canpro=$("#productos").val();
				        var total=0;
				        for(x=1;x<=canpro;x++){
				            var canti=$("#cant"+x).val();
				            if(canti!=""){
				                var subtotal=$("#sub"+x).val();
				            }else{
				                subtotal=0;
				            }
				            total=total+Number(subtotal);
				        }
				        iva_oculto=total*0.12;
				        iva_oculto=iva_oculto.toFixed(2);
				        iva=iva_oculto.replace(".", ",");
				        iva=formatNumber.new(iva_oculto);
				        document.getElementById("pretotal").value=total+" Bs.";
				        document.getElementById("iva").value=iva+" Bs.";
				        document.getElementById("iva_oculto").value=iva_oculto;
				    }
				    function unidad(){
				        var canpro=$("#productos").val();
				        var total=0;
				        for(x=1;x<=canpro;x++){
				            var prod=$("#prod"+x).val();
				            if(prod!=""){
				                var subtotal=$("#cant"+x).val();
				            }else{
				                subtotal=0;
				            }
				            total=Number(total)+Number(subtotal);
				            document.getElementById("uni_total").value=total;
				        }
				    }
					function total(){
				        var canpro=$("#productos").val();
				        var iva_oculto=$("#iva_oculto").val();
				        var total=0;
				        for(x=1;x<=canpro;x++){
				            var canti=$("#cant"+x).val();
				            if(canti!=""){
				                var subtotal=$("#sub"+x).val();
				            }else{
				                subtotal=0;
				            }
				            total=Number(total)+Number(subtotal);
				        }
				        //total=total+Number(iva_oculto);
				        total=total.toFixed(2);
				        total1=total.replace(".", ",");
				        total1=formatNumber.new(total1);
				        document.getElementById("subtot").value=total1+" Bs.";
				        document.getElementById("subtotal_num").value=total;
				        document.getElementById("total").value=total1+" Bs.";
				        document.getElementById("total_num").value=total;
				    }
					$("#cant"+<?php echo $this->art?>).change(function(){
				        var cant=$("#cant"+<?php echo $this->art?>).val();
				        var precio=$("#precio"+<?php echo $this->art?>).val();
				        var unidades=$("#unidad"+<?php echo $this->art?>).val();
				        var subtotal=0;
				        var uni=$("uni_total");
				        cant=Number(cant);
				        unidades=Number(unidades);
				        precio=Number(precio);
				        if(cant==""){
				        	cant=0;
				        }
				        if(cant<=unidades){
				           	sub=precio*cant;
				           	sub=sub.toFixed(2);
				           	subt=sub.replace(".", ",");
				           	subt=formatNumber.new(subt);	
				           	document.getElementById("subtotal"+<?php echo $this->art;?>).value=subt+" Bs.";
				           	document.getElementById("sub"+<?php echo $this->art;?>).value=sub;
				           	//iva();
				           	unidad();
				           	total();
				        }else{
				            swal(
					            {title:'La cantidad de productos ingresado es mayor a la que hay en existencia!',
					            type:'warning',
					            confirmButtonText:'Cerrar'}
					        );
				            document.getElementById("cant"+<?php echo $this->art?>).value="";
				        }
				    });
				    $("#subtot").click(function(){
				    	var canpro=$("#productos").val();
				        var iva_oculto=$("#iva_oculto").val();
				        var total=0;
				        for(x=1;x<=canpro;x++){
				            var canti=$("#cant"+x).val();
				            if(canti!=""){
				                var subtotal=$("#sub"+x).val();
				            }else{
				                subtotal=0;
				            }
				            total=Number(total)+Number(subtotal);
				        }
				        //total=total+Number(iva_oculto);
				        total=total.toFixed(2);
				        total1=total.replace(".", ",");
				        total1=formatNumber.new(total1);
				        document.getElementById("subtot").value=total1+" Bs.";
				        document.getElementById("subtotal_num").value=total;
				        document.getElementById("total").value=total1+" Bs.";
				        document.getElementById("total_num").value=total;
				    });
				    $("#descuento2").click(function(){
				    	var desc=$("#descuento").val();
				    	var sub=$("#subtotal_num").val();
				    	var descuento=0;
				    	descuento=Number(sub)*Number(desc)/100;
				    	total=Number(sub)-descuento;
				    	descuento=descuento.toFixed(2);
				        descu=descuento.replace(".", ",");
				        descu=formatNumber.new(descu);
				        total=total.toFixed(2);
				        total1=total.replace(".", ",");
				        total1=formatNumber.new(total1);	
				        document.getElementById("descuento2").value=descu+" Bs.";
				        document.getElementById("desc_num").value=descuento;
				        document.getElementById("total").value=total1+" Bs.";
				        document.getElementById("total_num").value=total;
				    });
				    $("#descuento").change(function(){
				    	var desc=$("#descuento").val();
				    	var sub=$("#subtotal_num").val();
				    	var descuento=0;
				    	descuento=Number(sub)*Number(desc)/100;
				    	total=Number(sub)-descuento;
				    	descuento=descuento.toFixed(2);
				        descu=descuento.replace(".", ",");
				        descu=formatNumber.new(descu);
				        total=total.toFixed(2);
				        total1=total.replace(".", ",");
				        total1=formatNumber.new(total1);	
				        document.getElementById("descuento2").value=descu+" Bs.";
				        document.getElementById("desc_num").value=descuento;
				        document.getElementById("total").value=total1+" Bs.";
				        document.getElementById("total_num").value=total;
				    });
				</script>
		    	<input type="text" class="form-control" id="cant<?php echo $this->art;?>" name="cant<?php echo $this->art;?>" onkeypress="return solonumeros(event)">
		    	<input type="hidden" id="precio<?php echo $this->art;?>" value="<?php echo $data[0];?>">
		    	<input type="hidden" id="unidad<?php echo $this->art;?>" value="<?php echo $data[1];?>">
				<div>Disponible: <?php echo $data[1];?></div>
			<?php
		}
		public function precioJuguetes(){
			$this->art=$_POST['art'];
			$this->prod=$_POST['prod'];
			$this->alma=$_POST['alma'];
			$sql=$this->db->query("SELECT p.precio, e.unidades FROM existencia_juguetes e INNER JOIN productos_juguetes p ON e.id_producto=p.id_producto WHERE e.id_producto=$this->prod AND e.id_almacenadora=$this->alma LIMIT 1;");
			$data=$this->db->recorrer($sql);
			?>
				<script>
					var formatNumber={
 						separador: ".", // separador para los miles
 						sepDecimal: ',', // separador para los decimales
 						formatear:function (num){
	 						num+='';
							var splitStr=num.split('.');
							var splitLeft=splitStr[0];
							var splitRight=splitStr.length > 1 ? this.sepDecimal+splitStr[1] : '';
							var regx=/(\d+)(\d{3})/;
							while(regx.test(splitLeft)){
							 	splitLeft=splitLeft.replace(regx, '$1'+this.separador+'$2');
							}
 							return this.simbol + splitLeft+splitRight;
 						},
 						new:function(num, simbol){
 							this.simbol=simbol ||'';
 							return this.formatear(num);
 						}
					}
					function iva(){
				        var canpro=$("#productos").val();
				        var total=0;
				        for(x=1;x<=canpro;x++){
				            var canti=$("#cant"+x).val();
				            if(canti!=""){
				                var subtotal=$("#sub"+x).val();
				            }else{
				                subtotal=0;
				            }
				            total=total+Number(subtotal);
				        }
				        iva_oculto=total*0.12;
				        iva_oculto=iva_oculto.toFixed(2);
				        iva=iva_oculto.replace(".", ",");
				        iva=formatNumber.new(iva_oculto);
				        document.getElementById("pretotal").value=total+" Bs.";
				        document.getElementById("iva").value=iva+" Bs.";
				        document.getElementById("iva_oculto").value=iva_oculto;
				    }
				    function unidad(){
				        var canpro=$("#productos").val();
				        var total=0;
				        for(x=1;x<=canpro;x++){
				            var prod=$("#prod"+x).val();
				            if(prod!=""){
				                var subtotal=$("#cant"+x).val();
				            }else{
				                subtotal=0;
				            }
				            total=Number(total)+Number(subtotal);
				            document.getElementById("uni_total").value=total;
				        }
				    }
					function total(){
				        var canpro=$("#productos").val();
				        var iva_oculto=$("#iva_oculto").val();
				        var total=0;
				        for(x=1;x<=canpro;x++){
				            var canti=$("#cant"+x).val();
				            if(canti!=""){
				                var subtotal=$("#sub"+x).val();
				            }else{
				                subtotal=0;
				            }
				            total=Number(total)+Number(subtotal);
				        }
				        //total=total+Number(iva_oculto);
				        total=total.toFixed(2);
				        total1=total.replace(".", ",");
				        total1=formatNumber.new(total1);
				        document.getElementById("subtot").value=total1+" Bs.";
				        document.getElementById("subtotal_num").value=total;
				        document.getElementById("total").value=total1+" Bs.";
				        document.getElementById("total_num").value=total;
				    }
					$("#cant"+<?php echo $this->art?>).change(function(){
				        var cant=$("#cant"+<?php echo $this->art?>).val();
				        var precio=$("#precio"+<?php echo $this->art?>).val();
				        var unidades=$("#unidad"+<?php echo $this->art?>).val();
				        var subtotal=0;
				        var uni=$("uni_total");
				        cant=Number(cant);
				        unidades=Number(unidades);
				        precio=Number(precio);
				        if(cant==""){
				        	cant=0;
				        }
				        if(cant<=unidades){
				           	sub=precio*cant;
				           	sub=sub.toFixed(2);
				           	subt=sub.replace(".", ",");
				           	subt=formatNumber.new(subt);	
				           	document.getElementById("subtotal"+<?php echo $this->art;?>).value=subt+" Bs.";
				           	document.getElementById("sub"+<?php echo $this->art;?>).value=sub;
				           	//iva();
				           	unidad();
				           	total();
				        }else{
				            swal(
					            {title:'La cantidad de productos ingresado es mayor a la que hay en existencia!',
					            type:'warning',
					            confirmButtonText:'Cerrar'}
					        );
				            document.getElementById("cant"+<?php echo $this->art?>).value="";
				        }
				    });
				    $("#subtot").click(function(){
				    	var canpro=$("#productos").val();
				        var iva_oculto=$("#iva_oculto").val();
				        var total=0;
				        for(x=1;x<=canpro;x++){
				            var canti=$("#cant"+x).val();
				            if(canti!=""){
				                var subtotal=$("#sub"+x).val();
				            }else{
				                subtotal=0;
				            }
				            total=Number(total)+Number(subtotal);
				        }
				        //total=total+Number(iva_oculto);
				        total=total.toFixed(2);
				        total1=total.replace(".", ",");
				        total1=formatNumber.new(total1);
				        document.getElementById("subtot").value=total1+" Bs.";
				        document.getElementById("subtotal_num").value=total;
				        document.getElementById("total").value=total1+" Bs.";
				        document.getElementById("total_num").value=total;
				    });
				    $("#descuento2").click(function(){
				    	var desc=$("#descuento").val();
				    	var sub=$("#subtotal_num").val();
				    	var descuento=0;
				    	descuento=Number(sub)*Number(desc)/100;
				    	total=Number(sub)-descuento;
				    	descuento=descuento.toFixed(2);
				        descu=descuento.replace(".", ",");
				        descu=formatNumber.new(descu);
				        total=total.toFixed(2);
				        total1=total.replace(".", ",");
				        total1=formatNumber.new(total1);	
				        document.getElementById("descuento2").value=descu+" Bs.";
				        document.getElementById("desc_num").value=descuento;
				        document.getElementById("total").value=total1+" Bs.";
				        document.getElementById("total_num").value=total;
				    });
				    $("#descuento").change(function(){
				    	var desc=$("#descuento").val();
				    	var sub=$("#subtotal_num").val();
				    	var descuento=0;
				    	descuento=Number(sub)*Number(desc)/100;
				    	total=Number(sub)-descuento;
				    	descuento=descuento.toFixed(2);
				        descu=descuento.replace(".", ",");
				        descu=formatNumber.new(descu);
				        total=total.toFixed(2);
				        total1=total.replace(".", ",");
				        total1=formatNumber.new(total1);	
				        document.getElementById("descuento2").value=descu+" Bs.";
				        document.getElementById("desc_num").value=descuento;
				        document.getElementById("total").value=total1+" Bs.";
				        document.getElementById("total_num").value=total;
				    });
				</script>
		    	<input type="text" class="form-control" id="cant<?php echo $this->art;?>" name="cant<?php echo $this->art;?>" onkeypress="return solonumeros(event)">
		    	<input type="hidden" id="precio<?php echo $this->art;?>" value="<?php echo $data[0];?>">
		    	<input type="hidden" id="unidad<?php echo $this->art;?>" value="<?php echo $data[1];?>">
				<div>Disponible: <?php echo $data[1];?> Precio: <?php echo $precio=number_format($data[0], 2, ',', '.')." Bs.";?></div>
			<?php
		}
		public function __destruct(){
			$this->db->close();
		}
	}
?>