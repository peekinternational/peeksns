<?php
header("Content-Type:text/html; charset=euc-kr;"); 
require_once dirname(__FILE__).'./lib/nicepay/web/NicePayWEB.php';
require_once dirname(__FILE__).'./lib/nicepay/core/Constants.php';
require_once dirname(__FILE__).'./lib/nicepay/web/NicePayHttpServletRequestWrapper.php';
/*
*******************************************************
* <���� ��� ����>
* ����� ��� �ɼ��� ����� ȯ�濡 �µ��� �����ϼ���.
* �α� ���丮�� �� �����ϼ���.
*******************************************************
*/   
$nicepayWEB = new NicePayWEB();
$httpRequestWrapper = new NicePayHttpServletRequestWrapper($_REQUEST);
$_REQUEST = $httpRequestWrapper->getHttpRequestMap();
$payMethod = $_REQUEST['PayMethod'];
$merchantKey = "EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg==";

$nicepayWEB->setParam("NICEPAY_LOG_HOME","C:/log");             // �α� ���丮 ����
$nicepayWEB->setParam("APP_LOG","1");                           // ���ø����̼Ƿα� ��� ����(0: DISABLE, 1: ENABLE)
$nicepayWEB->setParam("EVENT_LOG","1");                         // �̺�Ʈ�α� ��� ����(0: DISABLE, 1: ENABLE)
$nicepayWEB->setParam("EncFlag","S");                           // ��ȣȭ�÷��� ����(N: ��, S:��ȣȭ)
$nicepayWEB->setParam("SERVICE_MODE", "PY0");                   // ���񽺸�� ����(���� ���� : PY0 , ��� ���� : CL0)
$nicepayWEB->setParam("Currency", "KRW");                       // ��ȭ ����(���� KRW(��ȭ) ����)
$nicepayWEB->setParam("PayMethod",$payMethod);                  // �������
$nicepayWEB->setParam("LicenseKey",$merchantKey);               // ����Ű

/*
*******************************************************
* <���� ��� �ʵ�>
* �Ʒ� ���� ������ �ܿ��� ���� Header�� ������ ������ Get ����
*******************************************************
*/
$responseDTO    = $nicepayWEB->doService($_REQUEST);

$resultCode     = $responseDTO->getParameter("ResultCode");     // ����ڵ� (���� ����ڵ�:3001)
$resultMsg      = $responseDTO->getParameter("ResultMsg");      // ����޽���
$authDate       = $responseDTO->getParameter("AuthDate");       // �����Ͻ� (YYMMDDHH24mmss)
$authCode       = $responseDTO->getParameter("AuthCode");       // ���ι�ȣ
$buyerName      = $responseDTO->getParameter("BuyerName");      // �����ڸ�
$mallUserID     = $responseDTO->getParameter("MallUserID");     // ȸ�����ID
$goodsName      = $responseDTO->getParameter("GoodsName");      // ��ǰ��
$mallUserID     = $responseDTO->getParameter("MallUserID");     // ȸ����ID
$mid            = $responseDTO->getParameter("MID");            // ����ID
$tid            = $responseDTO->getParameter("TID");            // �ŷ�ID
$moid           = $responseDTO->getParameter("Moid");           // �ֹ���ȣ
$amt            = $responseDTO->getParameter("Amt");            // �ݾ�
$cardQuota      = $responseDTO->getParameter("CardQuota");      // ī�� �Һΰ��� (00:�Ͻú�,02:2����)
$cardCode       = $responseDTO->getParameter("CardCode");       // ����ī����ڵ�
$cardName       = $responseDTO->getParameter("CardName");       // ����ī����
$bankCode       = $responseDTO->getParameter("BankCode");       // �����ڵ�
$bankName       = $responseDTO->getParameter("BankName");       // �����
$rcptType       = $responseDTO->getParameter("RcptType");       // ���� ������ Ÿ�� (0:�����������,1:�ҵ����,2:��������)
$rcptAuthCode   = $responseDTO->getParameter("RcptAuthCode");   // ���ݿ����� ���ι�ȣ
$carrier        = $responseDTO->getParameter("Carrier");        // ����籸��
$dstAddr        = $responseDTO->getParameter("DstAddr");        // �޴�����ȣ
$vbankBankCode  = $responseDTO->getParameter("VbankBankCode");  // ������������ڵ�
$vbankBankName  = $responseDTO->getParameter("VbankBankName");  // ������������
$vbankNum       = $responseDTO->getParameter("VbankNum");       // ������¹�ȣ
$vbankExpDate   = $responseDTO->getParameter("VbankExpDate");   // ��������Աݿ�����

/*
*******************************************************
* <���� ���� ���� Ȯ��>
*******************************************************
*/
$paySuccess = false;
if($payMethod == "CARD"){
    if($resultCode == "3001") $paySuccess = true;               // �ſ�ī��(���� ����ڵ�:3001)
}else if($payMethod == "BANK"){
    if($resultCode == "4000") $paySuccess = true;               // ������ü(���� ����ڵ�:4000)
}else if($payMethod == "CELLPHONE"){
    if($resultCode == "A000") $paySuccess = true;               // �޴���(���� ����ڵ�:A000)
}else if($payMethod == "VBANK"){
    if($resultCode == "4100") $paySuccess = true;               // �������(���� ����ڵ�:4100)
}else if($payMethod == "SSG_BANK"){
    if($resultCode == "0000") $paySuccess = true;               // SSG�������(���� ����ڵ�:0000)
}

?>
<!DOCTYPE html>
<html>
<head>
<title>NICEPAY PAY RESULT(EUC-KR)</title>
<meta charset="euc-kr">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes, target-densitydpi=medium-dpi" />
<link rel="stylesheet" type="text/css" href="./css/import.css"/>
</head>
<body> 
  <div class="payfin_area">
    <div class="top">NICEPAY PAY RESULT(EUC-KR)</div>
    <div class="conwrap">
      <div class="con">
        <div class="tabletypea">
          <table>
            <colgroup><col width="30%"/><col width="*"/></colgroup>
              <tr>
                <th><span>��� ����</span></th>
                <td>[<?=$resultCode?>]<?=$resultMsg?></td>
              </tr>
              <tr>
                <th><span>���� ����</span></th>
                <td><?=$payMethod?></td>
              </tr>
              <tr>
                <th><span>��ǰ��</span></th>
                <td><?=$goodsName?></td>
              </tr>
              <tr>
                <th><span>�ݾ�</span></th>
                <td><?=$amt?>��</td>
              </tr>
              <tr>
                <th><span>�ŷ����̵�</span></th>
                <td><?=$tid?></td>
              </tr>               
            <?php if($payMethod=="CARD"){?>
              <tr>
                <th><span>ī����</span></th>
                <td><?=$cardName?></td>
              </tr>
              <tr>
                <th><span>�Һΰ���</span></th>
                <td><?=$cardQuota?></td>
              </tr>
            <?php }else if($payMethod=="BANK"){?>
              <tr>
                <th><span>����</span></th>
                <td><?=$bankName?></td>
              </tr>
              <tr>
                <th><span>���ݿ����� Ÿ��</span></th>
                <td><?=$rcptType?>(0:�������,1:�ҵ����,2:��������)</td>
              </tr>
            <?php }else if($payMethod=="CELLPHONE"){?>
              <tr>
                <th><span>����� ����</span></th>
                <td><?=$carrier?></td>
              </tr>
              <tr>
                <th><span>�޴��� ��ȣ</span></th>
                <td><?=$dstAddr?></td>
              </tr>
            <?php }else if($payMethod=="VBANK"){?>
              <tr>
                <th><span>�Ա� ����</span></th>
                <td><?=$vbankBankName?></td>
              </tr>
              <tr>
                <th><span>�Ա� ����</span></th>
                <td><?=$vbankNum?></td>
              </tr>
              <tr>
                <th><span>�Ա� ����</span></th>
                <td><?=$vbankExpDate?></td>
              </tr>
            <?php }else if($payMethod=="SSG_BANK"){?>
              <tr>
                <th><span>����</span></th>
                <td><?=$bankName?></td>
              </tr>
              <tr>
                <th><span>���ݿ����� Ÿ�� (0:�������,1:�ҵ����,2:��������)</span></th>
                <td><?=$rcptType?></td>
              </tr>				  
            <?php }?>
          </table>
        </div>
      </div>
      <p>*�׽�Ʈ ���̵��ΰ�� ���� ���� 11�� 30�п� ��ҵ˴ϴ�.</p>
    </div>
  </div>
</body>
</html>