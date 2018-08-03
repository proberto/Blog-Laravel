<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\FPDF;

class GeradorPDFController extends Controller
{
    function SetDash($black=null, $white=null)
    {
        if($black!==null)
            $s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }

    public static function gerar($nome, $prestador, $endereco, $numero, $cidade, $estado, $cep, $servico, $data, $valorServico, $bandeira, $ultimosDigitos,$parcelas, $valorParcela, $nome_cli, $cpf_cli){
		$pdf = new FPDF();
		$pdf->AddPage('L');
		$pdf->SetFont('Arial','',12);

		
		$pdf->Image(public_path().'/img/blukan-logo.png',61,10,-150);
		$pdf->Image(public_path().'/img/blukan-logo.png',211,10,-150);

		$pdf->Cell(31);
		$pdf->Cell(0,40, utf8_decode($nome).', obrigado por escolher a Blukan.',0,0, 'L');

		$pdf->SetX(192);
		$pdf->Cell(0,40, utf8_decode($nome).', obrigado por escolher a Blukan.',0,0, 'L');

		$pdf->ln();

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Informações do Prestador'),0,0, 'L');
		$pdf->SetFont('Arial','',12);

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(-127);
		$pdf->Cell(0,10,utf8_decode('Informações do Prestador'),0,1, 'L');
		$pdf->SetFont('Arial','',12);		

		$pdf->Cell(0,8,utf8_decode($prestador),0,0, 'L');
		$pdf->Cell(-127);
		$pdf->Cell(0,8,utf8_decode($prestador),0,1, 'L');

		$pdf->Cell(0,5,utf8_decode($endereco.', '.$numero),0,0, 'L');		
		$pdf->Cell(-127);
		$pdf->Cell(0,5,utf8_decode($endereco.', '.$numero),0,1, 'L');

		$pdf->Cell(0,5,utf8_decode($cidade.', '.$estado),0,0, 'L');		
		$pdf->Cell(-127);
		$pdf->Cell(0,5,utf8_decode($cidade.', '.$estado),0,1, 'L');

		$pdf->Cell(0,5,utf8_decode('CEP: '.$cep),0,0, 'L');		
		$pdf->Cell(-127);
		$pdf->Cell(0,5,utf8_decode('CEP: '.$cep),0,1, 'L');		

		$pdf->ln();

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Informações do Serviço'),0,0, 'L');
		$pdf->SetFont('Arial','',12);

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(-127);
		$pdf->Cell(0,10,utf8_decode('Informações do Serviço'),0,1, 'L');
		$pdf->SetFont('Arial','',12);

		$pdf->Cell(0,8,utf8_decode('Serviço de ').$servico,0,0, 'L');
		$pdf->Cell(-127);
		$pdf->Cell(0,8,utf8_decode('Serviço de ').$servico,0,1, 'L');

		$pdf->Cell(0,5,utf8_decode('Realizado em ').$data,0,0, 'L');		
		$pdf->Cell(-127);		
		$pdf->Cell(0,5,utf8_decode('Realizado em ').$data,0,1, 'L');

		$pdf->ln();        

        $pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode("Informações do Cliente"),0,0, 'L');		
		$pdf->Cell(-127);
		$pdf->Cell(0,10,utf8_decode("Informações do Cliente"),0,1, 'L');
		$pdf->SetFont('Arial','',12);

		$pdf->Cell(0,8,"Sr(a). ".utf8_decode($nome_cli),0,0, 'L');
		$pdf->Cell(-127);
		$pdf->Cell(0,8,"Sr(a). ".utf8_decode($nome_cli),0,1, 'L');

		$pdf->Cell(0,5,"CPF: $cpf_cli",0,0, 'L');		
		$pdf->Cell(-127);
		$pdf->Cell(0,5,"CPF: $cpf_cli",0,1, 'L'); 

		//$this->SetDash(4,2);
		$pdf->Line(150, 0, 150, 210);        

		$pdf->ln();

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode("Detalhamento do Preço"),0,0, 'L');		
		$pdf->Cell(-127);
		$pdf->Cell(0,10,utf8_decode("Detalhamento do Preço"),0,1, 'L');
		$pdf->SetFont('Arial','',12);
		
		$pdf->Cell(0,5,utf8_decode('Valor do Serviço'),0,0, 'L');
		$pdf->Cell(-170);
		$pdf->Cell(0,5,'R$'.$valorServico,0,0, 'L');		
		$pdf->Cell(-127);
		$pdf->Cell(0,5,utf8_decode('Valor do Serviço'),0,0, 'L');		
		$pdf->Cell(-25);
		$pdf->Cell(0,5,'R$'.$valorServico,0,1, 'L');

		$pdf->ln();		
		
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'Detalhamento do Pagamento',0,0, 'L');
		$pdf->Cell(-127);
		$pdf->Cell(0,10,'Detalhamento do Pagamento',0,1, 'L');


		$pdf->SetFont('Arial','',12);
		$pdf->Cell(0,5,$bandeira.' '.'****'.' '.$ultimosDigitos,0,0, 'L');
		$pdf->Cell(-127);
		$pdf->Cell(0,5,$bandeira.' '.'****'.' '.$ultimosDigitos,0,1, 'L');



		$pdf->Cell(0,5,$parcelas.'x R$'.$valorParcela,0,0, 'L');		
		$pdf->Cell(-127);
		$pdf->Cell(0,5,$parcelas.'x R$'.$valorParcela,0,1, 'L');

		
		//$pdf->Cell(0,10,'Left text',1,1,'L');	
		//$pdf->Cell(0,10,'Right text',0,0,'R');

		$pdf->Image(public_path().'/img/rodape-pdf.png',0,250,-280);

		$pdf->Output();
		exit;
	}
}
