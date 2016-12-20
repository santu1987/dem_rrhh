<?php
require("../core/helpers/fpdf17/fpdf.php");
class pdf_lista_us extends FPDF
{
	//Metodo para la cabecera del pdf
	function Header()
	{
            $this->Image("../site_media/img/logo_tsj.jpg",20,16);
            $this->Image("../site_media/img/logo_dem.jpg",155,16,40,6);
            $this->Ln(28);
            $this->SetFont('Arial','B',12);
            $this->Cell(0,5,'LISTADO DE USUARIOS',0,0,'C');
            $this->Ln(10);
			$this->SetFillColor(169,169,169) ;
            $this->SetTextColor(1);
            $this->SetMargins(20, 5 , 20);
	        $this->Cell(10,5,"#",1,0,'C',1);
            $this->Cell(60,5,"Login",1,0,'C',1);
            $this->Cell(60,5,"Tipo de usuario",1,0,'C',1);
            $this->Cell(45,5,"Estatus",1,0,'C',1);
            $this->Ln();

    }
    //Metodo footter
    function Footer()
	{
		$this->SetY(-25);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//N�mero de p�gina
	    $this->Ln();
		$this->Ln(10);
		$this->SetFont('Arial','B',8);
		$this->Cell(60,3,'Pagina '.$this->PageNo().'/{nb}',0,0,'L');
		//$this->Cell(40,3,'admin_template ',0,0,'C');
		$this->Cell(120,3,date("d/m/Y h:m:s"),0,0,'R');					
		$this->Ln();
		$this->SetFillColor(0);
		
	}  
	//-----------------------------------------------------------------------------
	//--Para manejar el multicell sin novedad
	var $widths;
	var $aligns;
	function SetWidths($w)
	{
	    //Set the array of column widths
	    $this->widths=$w;
	}
	function SetAligns($a)
	{
	    //Set the array of column alignments
	    $this->aligns=$a;
	}
	function Row($data)
	{
	    //Calculate the height of the row
	    $nb=0;
	    for($i=0;$i<count($data);$i++)
	        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	    $h=5*$nb;
	    //Issue a page break first if needed
	    $this->CheckPageBreak($h);
	    //Draw the cells of the row
	    for($i=0;$i<count($data);$i++)
	    {
	        $w=$this->widths[$i];
	        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
	        //Save the current position
	        $x=$this->GetX();
	        $y=$this->GetY();
	        //Draw the border
	        $this->Rect($x,$y,$w,$h);
	        //Print the text
	        $this->MultiCell($w,5,$data[$i],0,$a);
	        //Put the position to the right of the cell
	        $this->SetXY($x+$w,$y);
	    }
	    //Go to the next line
	    $this->Ln($h);
	}
	function CheckPageBreak($h)
	{
	    //If the height h would cause an overflow, add a new page immediately
	    if($this->GetY()+$h>$this->PageBreakTrigger)
	        $this->AddPage($this->CurOrientation);
	}
	function NbLines($w,$txt)
	{
	    //Computes the number of lines a MultiCell of width w will take
	    $cw=&$this->CurrentFont['cw'];
	    if($w==0)
	        $w=$this->w-$this->rMargin-$this->x;
	    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	    $s=str_replace("\r",'',$txt);
	    $nb=strlen($s);
	    if($nb>0 and $s[$nb-1]=="\n")
	        $nb--;
	    $sep=-1;
	    $i=0;
	    $j=0;
	    $l=0;
	    $nl=1;
	    while($i<$nb)
	    {
	        $c=$s[$i];
	        if($c=="\n")
	        {
	            $i++;
	            $sep=-1;
	            $j=$i;
	            $l=0;
	            $nl++;
	            continue;
	        }
	        if($c==' ')
	            $sep=$i;
	        $l+=$cw[$c];
	        if($l>$wmax)
	        {
	            if($sep==-1)
	            {
	                if($i==$j)
	                    $i++;
	            }
	            else
	                $i=$sep+1;
	            $sep=-1;
	            $j=$i;
	            $l=0;
	            $nl++;
	        }
	        else
	            $i++;
	    }
	    return $nl;
	}
	//-----------------------------------------------------------------------------   
}
class pdf_constancias extends FPDF
{
	//Metodo para la cabecera del pdf
	function Header()
	{
		$this->SetMargins(25, 15 , 25);
        $this->SetFont('Arial','B',30);
        $this->Cell(0,5,'DEM',0,0,'C');
        $this->Ln(10);
        $this->SetFont('Arial','',12);
        $this->Cell(0,5,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(10);
        $this->SetFont('Arial','B',12);
        $this->Cell(0,5,utf8_decode('DIRECCIÓN EJECUTIVA DE LA MAGISTRATURA'),0,0,'C');
        $this->Ln(10);
        $this->SetFont('Arial','',12);
        $this->Cell(0,5,utf8_decode('Dirección General de Recursos Humanos'),0,0,'C');
        $this->Ln(10);
        $this->Cell(0,5,utf8_decode('Dirección de Servicios al Personal'),0,0,'C');
        $this->Ln(10);
        $this->SetFont('Arial','B',12);
		$this->Cell(0,5,'CONSTANCIA',0,0,'C');
        $this->Ln(10);
    }
    //Metodo footter
    function Footer()
	{
		$this->SetY(-25);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//N�mero de p�gina
	    $this->Ln();
		$this->Ln(10);
		$this->SetFont('Arial','B',8);
		$this->Cell(60,3,'Pagina '.$this->PageNo().'/{nb}',0,0,'L');
		//$this->Cell(40,3,'admin_template ',0,0,'C');
		$this->Cell(120,3,date("d/m/Y h:m:s"),0,0,'R');					
		$this->Ln();
		$this->SetFillColor(0);
		
	}
	//Metodo para escribir HTML
	function WriteHTML($html)
	{
	    // Intérprete de HTML
	    $html = str_replace("\n",' ',$html);
	    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
	    foreach($a as $i=>$e)
	    {
	        if($i%2==0)
	        {
	            // Text
	            if($this->HREF)
	                $this->PutLink($this->HREF,$e);
	            else
	                $this->Write(5,$e);
	        }
	        else
	        {
	            // Etiqueta
	            if($e[0]=='/')
	                $this->CloseTag(strtoupper(substr($e,1)));
	            else
	            {
	                // Extraer atributos
	                $a2 = explode(' ',$e);
	                $tag = strtoupper(array_shift($a2));
	                $attr = array();
	                foreach($a2 as $v)
	                {
	                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
	                        $attr[strtoupper($a3[1])] = $a3[2];
	                }
	                $this->OpenTag($tag,$attr);
	            }
	        }
	    }
	}
	//
	function OpenTag($tag, $attr)
	{
	    // Etiqueta de apertura
	    if($tag=='B' || $tag=='I' || $tag=='U')
	        $this->SetStyle($tag,true);
	    if($tag=='A')
	        $this->HREF = $attr['HREF'];
	    if($tag=='BR')
	        $this->Ln(5);
	}

	function CloseTag($tag)
	{
	    // Etiqueta de cierre
	    if($tag=='B' || $tag=='I' || $tag=='U')
	        $this->SetStyle($tag,false);
	    if($tag=='A')
	        $this->HREF = '';
	}

	function SetStyle($tag, $enable)
	{
	    // Modificar estilo y escoger la fuente correspondiente
	    $this->$tag += ($enable ? 1 : -1);
	    $style = '';
	    foreach(array('B', 'I', 'U') as $s)
	    {
	        if($this->$s>0)
	            $style .= $s;
	    }
	    $this->SetFont('',$style);
	}  
	//-----------------------------------------------------------------------------
}
?>