<?php
/*ȥ�������ַ��еĿո�---newtrim����*/
function newtrim($str)
{
    $j=strlen($str);
    $result="";

    for($i=0; $i<$j; $i++) {
        switch($str[$i]) {
            case chr(8):
                # ȥ���˸�
            case chr(9):
                # ȥ��tab
            case chr(10):
                # ȥ������
            case chr(13):
                # ȥ���س�
            case chr(255):
                #ȥ������ո�
                break;
            default:
                $result .= $str[$i];
        }
    }
    return $result;
}


/*�õ�һ�����ֵıʻ���---getnum()����*/
/** to be improved **/
function getnum($txt)
{
    $sql1="select * from bihua";
    $result = mysql_query($sql1);
    while($row=mysql_fetch_array($result)) {
        if(false !==strpos($row["hanzi"], $txt)) {
            return $row['num'];
        }
    }

    return 0;
}

/*������˸񡢵ظ����õ�����---getsancai()����*/
/** to be improved **/
/*function getsancai($tiange, $renge, $dige)
{
    $tian = $tiange%10;
    $ren = $renge%10;
    $di = $dige%10;
    switch($tian) {
        case 1:
        case 2:
            $tiantxt="ľ";
            break;
        case 3:
        case 4:
            $tiantxt="��";
            break;
        case 5:
        case 6:
            $tiantxt="��";
            break;
        case 7:
        case 8:
            $tiantxt="��";
            break;
        case 9:
        case 10:
        case 0:
            $tiantxt="ˮ";
    }

    switch($ren) {
        case 1:
        case 2:
            $rentxt="ľ";
            break;
        case 3:
        case 4:
            $rentxt="��";
            break;
        case 5:
        case 6:
            $rentxt="��";
            break;
        case 7:
        case 8:
            $rentxt="��";
            break;
        case 9:
        case 10:
        case 0:
            $rentxt="ˮ";
    }

    switch($di) {
        case 1:
        case 2:
            $ditxt="ľ";
            break;
        case 3:
        case 4:
            $ditxt="��";
            break;
        case 5:
        case 6:
            $ditxt="��";
            break;
        case 7:
        case 8:
            $ditxt="��";
            break;
        case 9:
        case 10:
        case 0:
            $ditxt="ˮ";
    }

    $total = $tiantxt . $rentxt . $ditxt;
    return $total;
}
*/
/*'����ת��ũ�����㷨 edit by huanghui*/
function hhcal($caltime) 
{

    //��ȡ��ǰϵͳʱ�� 
    $curTime = strtotime($caltime) ;
    //������ 
    $WeekName = array("������", "����һ", "���ڶ�", "������", "������", "������" , "������" );
    //������� 
    $TianGan = array("��", "��", "��" , "��" , "��", "��", "��", "��", "��", "��");
    //��֧���� 
    $DiZhi = array("��", "��", "��", "î", "��", "��", "��", "δ", "��", "��", "��", "��");
    //�������� 
    $ShuXiang = array("��", "ţ", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��" );
    //ũ�������� 
    $DayName = array("*", "��һ", "����" ,"����", "����" , "����" , "����" , "����" , "����" , "����" , "��ʮ" , "ʮһ" , "ʮ��" , "ʮ��" , "ʮ��" , "ʮ��" , "ʮ��" , "ʮ��" , "ʮ��" , "ʮ��" , "��ʮ" , "إһ" , "إ��", "إ��", "إ��" , "إ��" , "إ��" , "إ��" , "إ��" , "إ��" , "��ʮ" );
    //ũ���·��� 
    $MonName = array("*", "��", "��", "��", "��", "��", "��", "��", "��", "��", "ʮ", "ʮһ", "��"); 
    //����ÿ��ǰ������� 
    $MonthAdd = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334); 
    //ũ������ 
    $NongliData = array(2635 , 333387 , 1701 , 1748 , 267701 , 694 , 2391 , 133423 , 1175 , 396438 , 3402 , 3749 , 331177 , 1453 , 694 , 201326 , 2350 , 465197 , 3221 , 3402 , 400202 , 2901 , 1386 , 267611 , 605 , 2349 , 137515 , 2709 , 464533 , 1738 , 2901 , 330421 , 1242 , 2651 , 199255 , 1323 , 529706 , 3733 , 1706 , 398762 , 2741 , 1206 , 267438 , 2647 , 1318 , 204070 , 3477 , 461653 , 1386 , 2413 , 330077 , 1197 , 2637 , 268877 , 3365 , 531109 , 2900 , 2922 , 398042 , 2395 , 1179 , 267415 , 2635 , 661067 , 1701 , 1748 , 398772 , 2742 , 2391 , 330031 , 1175 , 1611 , 200010 , 3749 , 527717 , 1452 , 2742 , 332397 , 2350 , 3222 , 268949 , 3402 , 3493 , 133973 , 1386 , 464219 , 605 , 2349 , 334123 , 2709 , 2890 , 267946 , 2773 , 592565 , 1210 , 2651 , 395863 , 1323 , 2707 , 265877 );
    //���ɵ�ǰ�����ꡢ�¡��� ==> GongliStr 
    $curYear = date("Y", $curTime); 
    $curMonth = date("n", $curTime) ;
    $curDay = date("j", $curTime) ;
    $GongliStr = $curYear . "��" . $curMonth . "��" . $curDay . "��";

    //���ɵ�ǰ�������� ==> WeekdayStr 
    $curWeekday = date('w', $curTime) ;
    $WeekdayStr = $WeekName[$curWeekday]; 

    //���㵽��ʼʱ��1921��2��8�յ�������1921-2-8(���³�һ) 
    $TheDate = ($curYear - 1921) * 365 + intval(($curYear - 1921) / 4) + $curDay + $MonthAdd[intval($curMonth) - 1] - 38 ;
    if (($curYear%4) == 0 && $curMonth > 2){ 
        $TheDate = $TheDate + 1;
    }

    //����ũ����ɡ���֧���¡��� 
    $isEnd = 0 ;
    $m = 0 ;
    do{ 
        if ($NongliData[$m] < 4095) { 
            $k = 11 ;
     } else {
            $k = 12 ;
     } 
        $n = $k ;
        do{ 
            if ($n < 0) { 
                break;
      } 
            //��ȡNongliData(m)�ĵ�n��������λ��ֵ 
            $bit = $NongliData[$m]; 
            for($i=0; $i<$n; $i++) { 
                $bit = intval($bit / 2);
         } 
            $bit = $bit%2; 
            if ($TheDate <= 29 + $bit){ 
                $isEnd = 1 ;
                break;
            }
            $TheDate = $TheDate - 29 - $bit; 
            $n--;
     } while (true);

        if ($isEnd == 1) { 
            break;
     } 
        $m++;
    } while (true);
    $curYear = 1921 + $m ;
    $curMonth = $k - $n + 1 ;
    $curDay = $TheDate ;
    if ($k == 12) {
        if ($curMonth == intval($NongliData[$m] / 65536) + 1) { 
            $curMonth = 1 - $curMonth ;
        }
        elseif ($curMonth > intval($NongliData[$m] / 65536) + 1) { 
            $curMonth = $curMonth - 1 ;
        }
    }

    //����ũ����ɡ���֧������ ==> NongliStr
    $nlnian = $TianGan[((($curYear - 4)%60)%10)] . $DiZhi[((($curYear - 4)%60)%12)];
    $sx = $ShuXiang[((($curYear - 4)%60)%12)];
    //����ũ���¡��� ==> NongliDayStr 
    if ($curMonth < 1) { 
        $nlyue = $MonName[-1 * $curMonth] ;
    }
    else  {
        $nlyue = $MonName[$curMonth]; 
    }
    $nlri = $DayName[$curDay];
    $nonglistr= $nlnian . "|" . $nlyue . "|" . $nlri . "|" . $sx;
    return $nonglistr;
}

function Constellation($mDate)
{
    $time = strtotime($mDate);
    if(false===$time) {
        echo "������";
        return;
    }
    $a= date("j", $time) - (19 + intval(substr("102123444423", date("n", $time)-1, 1)));
    $a = $a>=0? 0:-1;

    //'����
    $Constellation = substr("ħ��ˮƿ˫������ţ˫�Ӿ�зʨ�Ӵ�Ů�����Ы����ħ��", (date("n", $time) + $a)*4 , 4) . "��" ;
    return $Constellation;
}


/*�滻���з��Ĺ��˺���*/
function rep($content)
{
    return str_replace(array("\n", "\r\n"), "<br>", $content);
}

function GbToBig($content)
{
    $s="��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,¢,£,¤,¥,¦,§,¨,«,¬,­,®,¯,°,±,²,³,¸,»,¼,½,¿,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,á,è,ê,í,ó,ô,ù,û,þ,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,ı,Ķ,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,š,Ţ,ť,Ŧ,ŧ,Ũ,ũ,ű,ŵ,ŷ,Ÿ,Ź,Ż,Ž,��,��,��,��,��,��,��,ƭ,Ʈ,Ƶ,ƶ,ƻ,ƾ,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,ǣ,Ǥ,ǥ,Ǧ,Ǩ,ǩ,ǫ,Ǯ,ǯ,Ǳ,ǳ,Ǵ,ǵ,ǹ,Ǻ,ǽ,Ǿ,ǿ,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,ȣ,ȧ,Ȩ,Ȱ,ȴ,ȵ,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,ɡ,ɥ,ɧ,ɨ,ɬ,ɱ,ɴ,ɸ,ɹ,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,ʤ,ʥ,ʦ,ʨ,ʪ,ʫ,ʬ,ʱ,ʴ,ʵ,ʶ,ʻ,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,˧,˫,˭,˰,˳,˵,˶,˸,˿,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,̡,̢,̧,̯,̰,̱,̲,̳,̷,̸,̾,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,ͭ,ͳ,ͷ,ͼ,Ϳ,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,Τ,Υ,Χ,Ϊ,Ϋ,ά,έ,ΰ,α,γ,ν,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,Ϯ,ϰ,ϳ,Ϸ,ϸ,Ϻ,Ͻ,Ͽ,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,Х,Ы,Э,Ю,Я,в,г,д,к,л,п,��,��,��,��,��,��,��,��,��,��,��,��,��,ѡ,Ѣ,Ѥ,ѧ,ѫ,ѯ,Ѱ,ѱ,ѵ,Ѷ,ѷ,ѹ,ѻ,Ѽ,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,ҡ,Ң,ң,Ҥ,ҥ,ҩ,ү,ҳ,ҵ,Ҷ,ҽ,ҿ,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,ӣ,Ӥ,ӥ,Ӧ,ӧ,Ө,ө,Ӫ,ӫ,Ӭ,ӱ,Ӵ,ӵ,Ӷ,Ӹ,ӻ,ӽ,ӿ,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,Ԥ,Ԧ,ԧ,Ԩ,ԯ,԰,Ա,Բ,Ե,Զ,Ը,Լ,Ծ,Կ,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,ա,բ,թ,ի,ծ,ձ,յ,ն,շ,ո,ջ,ս,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,֡,֣,֤,֯,ְ,ִ,ֽ,ֿ,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,��,פ,ר,ש,ת,׬,׮,ׯ,װ,ױ,׳,״,׶,׸,׹,׺,׻,��,��,��,��,��,��,��,��,��,��,��,��,��,��,ô,Ϊ,ֻ,��,׼,��,��,��,��,��,��,й";

    $t="�,�},�@,�K,��,�O,�\,�W,��,�T,�[,��,�C,�k,�O,��,��,�^,�r,��,�,��,��,�U,݅,ؐ,�^,�N,��,�v,��,�P,��,��,�],߅,��,�H,׃,�q,�p,��,�T,�l,�I,�e,�P,�,��,��,�K,�g,�N,�a,��,�Q,��,�M,�K,�N,�n,œ,�},��,��,��,��,�y,��,Ԍ,�v,��,�s,�,׋,�p,�P,�b,�U,�,��,�L,�L,��,�c,�S,��,�n,܇,��,�m,�,�r,��,�Q,��,�\,�G,�V,�t,�Y,�u,�X,��,�_,�x,��,��,�P,�I,�I,�h,��,�N,�z,�r,�A,��,�|,̎,��,��,�J,��,�N,��,�b,�o,�~,�n,,�[,��,��,��,��,�Z,�e,�_,��,�J,��,��,��,��,đ,��,�Q,��,��,��,�h,ʎ,�n,�v,�u,�\,��,�I,��,��,��,��,�f,��,�c,�|,�,��,�,�{,��,ՙ,�B,�,�,�V,ӆ,�|,��,��,��,�Y,��,��,�x,ـ,�,�,��,��,��,�,��,��,�D,�g,�Z,�Z,�~,Ӟ,��,�I,��,��,�D,�E,�l,�P,�y,�m,�\,�C,��,��,؜,�,�L,��,�w,�U,�M,��,��,�^,��,�S,�S,��,�h,�L,��,�T,�p,�S,�P,�w,ݗ,��,�o,�x,�},ؓ,Ӈ,�D,�`,ԓ,�},�w,��,�s,��,�M,��,��,�,�V,��,�V,�,�R,��,�w,�t,��,�o,��,�m,�,ؕ,�h,��,��,ُ,��,�M,�,��,�P,�^,�^,�T,؞,�V,Ҏ,��,�w,��,�|,܉,Ԏ,��,�F,��,݁,�L,�,��,�^,�,�n,�h,�u,�Q,�R,�M,�Z,��,�t,��,��,�o,��,��,�W,�A,��,��,Ԓ,��,��,�g,�h,߀,��,�Q,��,��,��,�o,�S,�e,�],�x,��,�V,�x,��,�Z,��,�M,�d,�L,ȝ,��,�,�@,؛,��,��,�C,�e,��,�I,�u,��,��,�O,݋,��,�D,��,�E,��,��,Ӌ,ӛ,�H,�^,�o,�A,�v,�a,�Z,�,�r,�{,��,�O,��,�{,�g,�D,�},�O,�z,�A,�|,��,��,��,��,�p,�],��,�b,�`,�v,Ҋ,�I,Ş,��,�T,�u,�R,��,�{,�Y,��,��,�v,�u,�z,��,�,��,��,�q,�C,�e,�_,�,�U,�g,�I,�^,�M,�A,��,�o,�@,��,�i,�o,�R,��,�d,��,�Q,�m,��,�f,�x,�e,��,�,��,��,�N,��,��,��,�Y,�],��,�o,�\,�H,֔,�M,�x,�a,�M,��,�G,�X,�Q,�E,�^,�x,܊,�E,�_,�P,�w,��,�n,��,��,��,��,ѝ,�F,�K,�~,��,�V,��,�r,̝,�h,�Q,��,��,�U,�,Ϟ,�D,�R,��,ه,�{,��,�r,�@,�@,�m,��,׎,��,�[,��,�|,��,�E,��,��,��,��,�D,��,�,�I,�h,�x,�Y,��,�Y,��,��,��,�[,��,�r,�`,�z,,ɏ,�B,�,�z,�i,��,��,Ę,�,��,��,��,�Z,��,��,�v,Տ,��,�|,�,�C,�R,��,�[,�C,�U,�g,�,�R,�`,�X,�I,�s,��,��,�@,��,�\,��,�n,�],��,��,��,�t,�J,�R,�B,�],�t,��,�u,̔,��,�T,��,�,�,�H,��,�X,�H,��,�|,�],�V,�G,�n,��,�\,��,�y,��,݆,��,��,�S,�],Փ,�},�_,߉,�,�j,�,�,�j,��,��,�a,Λ,�R,�R,��,�I,��,�u,�~,�},�m,�z,�U,�M,֙,؈,�^,�T,�Q,��,�q,�],�V,�T,��,��,�i,��,�i,��,Ғ,�d,��,�R,��,��,�},�Q,�,և,�\,��,�c,�{,�y,��,�X,��,�[,�H,ā,�f,��,�,�B,,�m,�,�,��,��,�,�Q,��,�o,�~,ē,��,�r,��,�Z,�W,�t,��,�I,�a,�P,��,��,��,�r,��,�i,�_,�h,�l,ؚ,�O,�{,�u,��,�H,��,�,��,�V,Ě,�R,�T,�M,��,��,��,ә,��,�L,�T,�U,�w,��,�t,�X,�Q,��,�\,�l,�q,��,��,��,�N,��,��,�@,��,��,�S,�N,�[,�`,�J,�H,�p,��,�A,�,Ո,�c,��,�F,څ,�^,�|,�,�x,�E,��,��,�s,�o,׌,��,�_,�@,��,�g,�J,�x,�s,�q,ܛ,�J,�c,��,��,�_,�w,ِ,��,��,�},��,��,��,��,�Y,��,�W,�,٠,��,��,�p,��,�B,�d,�z,��,�O,��,��,��,�I,�B,,�K,��,�},��,�{,��,Ԋ,��,�r,�g,��,�R,�,��,�,�,ҕ,ԇ,��,�F,��,ݔ,��,�H,��,�g,��,�Q,��,��,�p,�l,��,�,�f,�T,�q,�z,�,,�Z,�,�A,�b,�\,�K,�V,�C,�m,��,�q,�O,�p,�S,�s,��,�i,�H,��,�E,��,؝,�c,��,��,�T,Մ,�U,��,�C,��,�l,�v,�`,�R,�},�w,��,�l,�N,�F,�d, ,�N,�~,�y,�^,�D,�T,�F,�j,͑,Ó,�r,�W,�,�E,�D,�m,��,��,�B,�f,�W,�f,�`,��,��,�H,�S,Ȕ,��,�^,��,�^,�l,��,,�y,��,��,�Y,��,΁,�u,�C,��,�u,��,�_,�o,ʏ,��,�],�F,��,�`,�a,��,�u,��,�,��,��,�r,ݠ,�{,�b,�M,�B,�v,�r,�w,�y,�t,�,�e,�@,�U,�F,�I,�h,�W,�w,��,��,��,�,�l,Ԕ,�,�,ʒ,�N,��,�[,ϐ,�f,��,�y,�{,�C,��,�a,�x,�\,�,�d,��,�n,�C,̓,�u,�,�S,�w,�m,܎,��,�x,�_,�k,�W,��,ԃ,��,�Z,Ӗ,Ӎ,�d,��,�f,��,��,��,Ӡ,�,��,�},��,�,�,�W,��,��,��,�V,�,��,��,�P,��,�W,�B,��,��,�u,��,�b,�G,�{,ˎ,��,�,�I,�~,�t,�,�U,�z,�x,��,ρ,ˇ,�|,��,�x,Ԅ,�h,�x,�g,��,�[,�a,�,�y,�,��,��,��,��,�t,��,Ξ,�I,��,ω,�f,��,��,��,�b,�x,ԁ,��,��,�n,�],�,�q,�[,�T,ݛ,�~,�O,��,�c,�Z,�Z,�n,�R,�z,�u,�A,�S,�x,�Y,�@,�@,�T,�A,��,�h,�,�s,�S,�,�[,��,��,�,�,�y,��,�E,�\,�N,�j,��,�,�s,��,�d,��,��,ٝ,�E,�v,�,��,�^,؟,��,�t,��,�\,ٛ,��,��,܈,�,�l,�p,�S,��,��,�K,��,ݚ,��,��,��,�`,��,�q,��,�~,Û,�w,�U,�H,�N,�@,ؑ,�,��,�\,�,�,��,��,�b,��,��,�C,��,,��,��,��,�S,��,�|,�R,�K,�N,�[,�\,�a,�S,��,��,�E,�i,�T,�D,�T,��,��,�A,�T,�B,�v,��,�u,�D,ٍ,��,�f,�b,�y,��,��,�F,٘,��,�Y,Ձ,��,Ɲ,�Y,�n,ۙ,�C,��,�v,�u,�{,�M,�,�@,�,�N,��,�b,��,��,��,�,�e,�Z,�N,�,��";

    $s=explode(",", $s);
    $t=explode(",", $t);
    $content=str_replace($s, $t, $content);

    return $content;
}


/*�õ�һ��������������*/
function getzywh($txt)
{
    $sql1="select * from hzwh";
    $rs1=mysql_query($sql1);
    while($row=mysql_fetch_array($rs1)){
        if(false!==strpos($row["hz"], $txt)) {
            return $row["wh"];
        }
    }
	   
    return '';
}

function getsancai($sc)
{
    $sc=$sc%10;
    switch($sc){
        case 1:
        case 2:
            $sctxt="ľ";
        break;
        case 3:
        case 4:
            $sctxt="��";
        break;
        case 5:
        case 6:
            $sctxt="��";
        break;
        case 7:
        case 8:
            $sctxt="��";
        break;
        case 9:
        case 10:
        case 0:
            $sctxt="ˮ";
        break;
    }

    return $sctxt;
}

function DiZhi($i)
{
    $arr = array("��", "��","��","��","��","î","î","��","��","��","��","��","��","δ","δ","��","��","��","��","��","��","��","��","��");
    return $arr[$i];
}


function getpf($sc)
{
    $arr = array("��" =>12, "��"=>8, "�뼪"=>5, "����"=> 0, "��"=> 1, "����"=> 2, "ƽ"=>4);
    return $arr[$sc];
}

/*����*/
function layin($tgdz)
{
    $sql1="select * from jiazi";
    $rs1=mysql_query($sql1);
    while($row=mysql_fetch_array($rs1)){
        if(false!==strpos($row["jiazi"], $tgdz)) {
            return $row["layin"];
        }
    }
	   
    return '';
}

function tgdzwh($tgdz)
{
    $arr = array("��" => "ˮ"
                ,"��" => "ˮ"
                ,"��" => "ľ"
                ,"î" => "ľ"
                ,"��" => "��"
                ,"��" => "��"
                ,"��" => "��"
                ,"��" => "��"
                ,"��" => "��"
                ,"��" => "��"
                ,"��" => "��"
                ,"δ" => "��"
                ,"��" => "ľ"
                ,"��" => "ľ"
                ,"��" => "��"
                ,"��" => "��"
                ,"��" => "��"
                ,"��" => "��"
                ,"��" => "��"
                ,"��" => "��"
                ,"��" => "ˮ"
                ,"��" => "ˮ"
                );
    return $arr[$tgdz];
}

function siji($yue)
{
    $arr = array ("1" => "��"
                    ,"2" => "��"
                    ,"3" => "��"
                    ,"4" => "��"
                    ,"5" => "��"
                    ,"6" => "��"
                    ,"7" => "��"
                    ,"8" => "��"
                    ,"9" => "��"
                    ,"10" => "��"
                    ,"11" => "��"
                    ,"12" => "��");
    return $arr[$yue];
} 


function g($num)
{
    static $d = array(
        "a" => -20319 
        ,"ai" => -20317 
        ,"an" => -20304 
        ,"ang" => -20295 
        ,"ao" => -20292 
        ,"ba" => -20283 
        ,"bai" => -20265 
        ,"ban" => -20257 
        ,"bang" => -20242 
        ,"bao" => -20230 
        ,"bei" => -20051 
        ,"ben" => -20036 
        ,"beng" => -20032 
        ,"bi" => -20026 
        ,"bian" => -20002 
        ,"biao" => -19990 
        ,"bie" => -19986 
        ,"bin" => -19982 
        ,"bing" => -19976 
        ,"bo" => -19805 
        ,"bu" => -19784 
        ,"ca" => -19775 
        ,"cai" => -19774 
        ,"can" => -19763 
        ,"cang" => -19756 
        ,"cao" => -19751 
        ,"ce" => -19746 
        ,"ceng" => -19741 
        ,"cha" => -19739 
        ,"chai" => -19728 
        ,"chan" => -19725 
        ,"chang" => -19715 
        ,"chao" => -19540 
        ,"che" => -19531 
        ,"chen" => -19525 
        ,"cheng" => -19515 
        ,"chi" => -19500 
        ,"chong" => -19484 
        ,"chou" => -19479 
        ,"chu" => -19467 
        ,"chuai" => -19289 
        ,"chuan" => -19288 
        ,"chuang" => -19281 
        ,"chui" => -19275 
        ,"chun" => -19270 
        ,"chuo" => -19263 
        ,"ci" => -19261 
        ,"cong" => -19249 
        ,"cou" => -19243 
        ,"cu" => -19242 
        ,"cuan" => -19238 
        ,"cui" => -19235 
        ,"cun" => -19227 
        ,"cuo" => -19224 
        ,"da" => -19218 
        ,"dai" => -19212 
        ,"dan" => -19038 
        ,"dang" => -19023 
        ,"dao" => -19018 
        ,"de" => -19006 
        ,"deng" => -19003 
        ,"di" => -18996 
        ,"dian" => -18977 
        ,"diao" => -18961 
        ,"die" => -18952 
        ,"ding" => -18783 
        ,"diu" => -18774 
        ,"dong" => -18773 
        ,"dou" => -18763 
        ,"du" => -18756 
        ,"duan" => -18741 
        ,"dui" => -18735 
        ,"dun" => -18731 
        ,"duo" => -18722 
        ,"e" => -18710 
        ,"en" => -18697 
        ,"er" => -18696 
        ,"fa" => -18526 
        ,"fan" => -18518 
        ,"fang" => -18501 
        ,"fei" => -18490 
        ,"fen" => -18478 
        ,"feng" => -18463 
        ,"fo" => -18448 
        ,"fou" => -18447 
        ,"fu" => -18446 
        ,"ga" => -18239 
        ,"gai" => -18237 
        ,"gan" => -18231 
        ,"gang" => -18220 
        ,"gao" => -18211 
        ,"ge" => -18201 
        ,"gei" => -18184 
        ,"gen" => -18183 
        ,"geng" => -18181 
        ,"gong" => -18012 
        ,"gou" => -17997 
        ,"gu" => -17988 
        ,"gua" => -17970 
        ,"guai" => -17964 
        ,"guan" => -17961 
        ,"guang" => -17950 
        ,"gui" => -17947 
        ,"gun" => -17931 
        ,"guo" => -17928 
        ,"ha" => -17922 
        ,"hai" => -17759 
        ,"han" => -17752 
        ,"hang" => -17733 
        ,"hao" => -17730 
        ,"he" => -17721 
        ,"hei" => -17703 
        ,"hen" => -17701 
        ,"heng" => -17697 
        ,"hong" => -17692 
        ,"hou" => -17683 
        ,"hu" => -17676 
        ,"hua" => -17496 
        ,"huai" => -17487 
        ,"huan" => -17482 
        ,"huang" => -17468 
        ,"hui" => -17454 
        ,"hun" => -17433 
        ,"huo" => -17427 
        ,"ji" => -17417 
        ,"jia" => -17202 
        ,"jian" => -17185 
        ,"jiang" => -16983 
        ,"jiao" => -16970 
        ,"jie" => -16942 
        ,"jin" => -16915 
        ,"jing" => -16733 
        ,"jiong" => -16708 
        ,"jiu" => -16706 
        ,"ju" => -16689 
        ,"juan" => -16664 
        ,"jue" => -16657 
        ,"jun" => -16647 
        ,"ka" => -16474 
        ,"kai" => -16470 
        ,"kan" => -16465 
        ,"kang" => -16459 
        ,"kao" => -16452 
        ,"ke" => -16448 
        ,"ken" => -16433 
        ,"keng" => -16429 
        ,"kong" => -16427 
        ,"kou" => -16423 
        ,"ku" => -16419 
        ,"kua" => -16412 
        ,"kuai" => -16407 
        ,"kuan" => -16403 
        ,"kuang" => -16401 
        ,"kui" => -16393 
        ,"kun" => -16220 
        ,"kuo" => -16216 
        ,"la" => -16212 
        ,"lai" => -16205 
        ,"lan" => -16202 
        ,"lang" => -16187 
        ,"lao" => -16180 
        ,"le" => -16171 
        ,"lei" => -16169 
        ,"leng" => -16158 
        ,"li" => -16155 
        ,"lia" => -15959 
        ,"lian" => -15958 
        ,"liang" => -15944 
        ,"liao" => -15933 
        ,"lie" => -15920 
        ,"lin" => -15915 
        ,"ling" => -15903 
        ,"liu" => -15889 
        ,"long" => -15878 
        ,"lou" => -15707 
        ,"lu" => -15701 
        ,"lv" => -15681 
        ,"luan" => -15667 
        ,"lue" => -15661 
        ,"lun" => -15659 
        ,"luo" => -15652 
        ,"ma" => -15640 
        ,"mai" => -15631 
        ,"man" => -15625 
        ,"mang" => -15454 
        ,"mao" => -15448 
        ,"me" => -15436 
        ,"mei" => -15435 
        ,"men" => -15419 
        ,"meng" => -15416 
        ,"mi" => -15408 
        ,"mian" => -15394 
        ,"miao" => -15385 
        ,"mie" => -15377 
        ,"min" => -15375 
        ,"ming" => -15369 
        ,"miu" => -15363 
        ,"mo" => -15362 
        ,"mou" => -15183 
        ,"mu" => -15180 
        ,"na" => -15165 
        ,"nai" => -15158 
        ,"nan" => -15153 
        ,"nang" => -15150 
        ,"nao" => -15149 
        ,"ne" => -15144 
        ,"nei" => -15143 
        ,"nen" => -15141 
        ,"neng" => -15140 
        ,"ni" => -15139 
        ,"nian" => -15128 
        ,"niang" => -15121 
        ,"niao" => -15119 
        ,"nie" => -15117 
        ,"nin" => -15110 
        ,"ning" => -15109 
        ,"niu" => -14941 
        ,"nong" => -14937 
        ,"nu" => -14933 
        ,"nv" => -14930 
        ,"nuan" => -14929 
        ,"nue" => -14928 
        ,"nuo" => -14926 
        ,"o" => -14922 
        ,"ou" => -14921 
        ,"pa" => -14914 
        ,"pai" => -14908 
        ,"pan" => -14902 
        ,"pang" => -14894 
        ,"pao" => -14889 
        ,"pei" => -14882 
        ,"pen" => -14873 
        ,"peng" => -14871 
        ,"pi" => -14857 
        ,"pian" => -14678 
        ,"piao" => -14674 
        ,"pie" => -14670 
        ,"pin" => -14668 
        ,"ping" => -14663 
        ,"po" => -14654 
        ,"pu" => -14645 
        ,"qi" => -14630
        ,"qia" => -14594 
        ,"qian" => -14429 
        ,"qiang" => -14407 
        ,"qiao" => -14399 
        ,"qie" => -14384 
        ,"qin" => -14379 
        ,"qing" => -14368 
        ,"qiong" => -14355 
        ,"qiu" => -14353 
        ,"qu" => -14345 
        ,"quan" => -14170 
        ,"que" => -14159 
        ,"qun" => -14151 
        ,"ran" => -14149 
        ,"rang" => -14145 
        ,"rao" => -14140 
        ,"re" => -14137 
        ,"ren" => -14135 
        ,"reng" => -14125 
        ,"ri" => -14123 
        ,"rong" => -14122 
        ,"rou" => -14112 
        ,"ru" => -14109 
        ,"ruan" => -14099 
        ,"rui" => -14097 
        ,"run" => -14094 
        ,"ruo" => -14092 
        ,"sa" => -14090 
        ,"sai" => -14087 
        ,"san" => -14083 
        ,"sang" => -13917 
        ,"sao" => -13914 
        ,"se" => -13910 
        ,"sen" => -13907 
        ,"seng" => -13906 
        ,"sha" => -13905 
        ,"shai" => -13896 
        ,"shan" => -13894 
        ,"shang" => -13878 
        ,"shao" => -13870 
        ,"she" => -13859 
        ,"shen" => -13847 
        ,"sheng" => -13831 
        ,"shi" => -13658 
        ,"shou" => -13611 
        ,"shu" => -13601 
        ,"shua" => -13406 
        ,"shuai" => -13404 
        ,"shuan" => -13400 
        ,"shuang" => -13398 
        ,"shui" => -13395 
        ,"shun" => -13391 
        ,"shuo" => -13387 
        ,"si" => -13383 
        ,"song" => -13367 
        ,"sou" => -13359 
        ,"su" => -13356 
        ,"suan" => -13343 
        ,"sui" => -13340 
        ,"sun" => -13329 
        ,"suo" => -13326 
        ,"ta" => -13318 
        ,"tai" => -13147 
        ,"tan" => -13138 
        ,"tang" => -13120 
        ,"tao" => -13107 
        ,"te" => -13096 
        ,"teng" => -13095 
        ,"ti" => -13091 
        ,"tian" => -13076 
        ,"tiao" => -13068 
        ,"tie" => -13063 
        ,"ting" => -13060 
        ,"tong" => -12888 
        ,"tou" => -12875 
        ,"tu" => -12871 
        ,"tuan" => -12860 
        ,"tui" => -12858 
        ,"tun" => -12852 
        ,"tuo" => -12849 
        ,"wa" => -12838 
        ,"wai" => -12831 
        ,"wan" => -12829 
        ,"wang" => -12812 
        ,"wei" => -12802 
        ,"wen" => -12607 
        ,"weng" => -12597 
        ,"wo" => -12594 
        ,"wu" => -12585 
        ,"xi" => -12556 
        ,"xia" => -12359 
        ,"xian" => -12346 
        ,"xiang" => -12320 
        ,"xiao" => -12300 
        ,"xie" => -12120 
        ,"xin" => -12099 
        ,"xing" => -12089 
        ,"xiong" => -12074 
        ,"xiu" => -12067 
        ,"xu" => -12058 
        ,"xuan" => -12039 
        ,"xue" => -11867 
        ,"xun" => -11861 
        ,"ya" => -11847 
        ,"yan" => -11831 
        ,"yang" => -11798 
        ,"yao" => -11781 
        ,"ye" => -11604 
        ,"yi" => -11589 
        ,"yin" => -11536 
        ,"ying" => -11358 
        ,"yo" => -11340 
        ,"yong" => -11339 
        ,"you" => -11324 
        ,"yu" => -11303 
        ,"yuan" => -11097 
        ,"yue" => -11077 
        ,"yun" => -11067 
        ,"za" => -11055 
        ,"zai" => -11052 
        ,"zan" => -11045 
        ,"zang" => -11041 
        ,"zao" => -11038 
        ,"ze" => -11024 
        ,"zei" => -11020 
        ,"zen" => -11019 
        ,"zeng" => -11018 
        ,"zha" => -11014 
        ,"zhai" => -10838 
        ,"zhan" => -10832 
        ,"zhang" => -10815 
        ,"zhao" => -10800 
        ,"zhe" => -10790 
        ,"zhen" => -10780 
        ,"zheng" => -10764 
        ,"zhi" => -10587 
        ,"zhong" => -10544 
        ,"zhou" => -10533 
        ,"zhu" => -10519 
        ,"zhua" => -10331 
        ,"zhuai" => -10329 
        ,"zhuan" => -10328 
        ,"zhuang" => -10322 
        ,"zhui" => -10315 
        ,"zhun" => -10309 
        ,"zhuo" => -10307 
        ,"zi" => -10296 
        ,"zong" => -10281 
        ,"zou" => -10274 
        ,"zu" => -10270 
        ,"zuan" => -10262 
        ,"zui" => -10260 
        ,"zun" => -10256 
        ,"zuo" => -10254 );

    $aa = array_values($d);
    $b = array_keys($d);

    if($num>0 && $num<160) {
        return chr($num);
    }
    if($num<-20319 || $num>-10247){
        return '';
    }
    $k=count($aa);
    while($k--){
        if($aa[$k]<=$num){
            break;
        }
    }
    return $b[$k];
}

function c($str)
{
    $c="" ;

    $strLen = strlen($str);
    for($k=0; $k<$strLen; $k++){
        $charCode = ord(substr($str, $k, 1));
        if($charCode>=0x80 && $charCode<=0xFF) {
            $charLowCode = ord(substr($str, ++$k, 1));
            $charCode = $charCode*256 + $charLowCode - 65536;

        }
        $c .= g($charCode); 
    }
    return $c;
}


//д��cookies---writecookies()
function writecookies()
{
	if (count($_POST)) {
		$xing=newtrim($_REQUEST['xing']);
		$ming=newtrim($_REQUEST['ming']);
		$xingbie=newtrim($_REQUEST['xingbie']);
		$xuexing=newtrim($_REQUEST['xuexing']);
		//����
		$nian1=newtrim($_REQUEST['nian']);
		$yue1=newtrim($_REQUEST['yue']);
		$ri1=newtrim($_REQUEST['ri']);
		$hh1=newtrim($_REQUEST['hh']);
		$mm1=newtrim($_REQUEST['mm']);
		//ũ��
		$glstr= $nian1 . "-" . $yue1 . "-" . $ri1;
		$nlstr=hhcal($glstr);
		$nlarray=explode('|' , $nlstr);
		$nlnian=$nlarray[0];
		$nlyue=$nlarray[1];
		$nlri=$nlarray[2];
		$sx=$nlarray[3];

		$cookieExpire = time()+3600;
		setcookie ('laisuanming[xing]', $xing , $cookieExpire, '/');
		setcookie ('laisuanming[ming]', $ming , $cookieExpire, '/');
		setcookie ('laisuanming[xingbie]', $xingbie , $cookieExpire, '/');
		setcookie ('laisuanming[xuexing]', $xuexing , $cookieExpire, '/');
		//����
		setcookie ('laisuanming[nian1]', $nian1 , $cookieExpire, '/');
		setcookie ('laisuanming[yue1]', $yue1 , $cookieExpire, '/');
		setcookie ('laisuanming[ri1]', $ri1 , $cookieExpire, '/');
		setcookie ('laisuanming[hh1]', $hh1 , $cookieExpire, '/');
		setcookie ('laisuanming[mm1]', $mm1 , $cookieExpire, '/');
		//ũ��
		setcookie ('laisuanming[nian2]', $nlnian , $cookieExpire, '/');
		setcookie ('laisuanming[yue2]', $nlyue , $cookieExpire, '/');
		setcookie ('laisuanming[ri2]', $nlri , $cookieExpire, '/');
		setcookie ('laisuanming[hh2]', $hh1 , $cookieExpire, '/');
		setcookie ('laisuanming[mm2]', $mm1 , $cookieExpire, '/');
		setcookie ('laisuanming[sx]', $sx , $cookieExpire, '/');

  $_COOKIE['laisuanming']['xing'] = $xing;
		$_COOKIE['laisuanming']['ming'] = $ming;
		$_COOKIE['laisuanming']['xingbie'] = $xingbie;
		$_COOKIE['laisuanming']['xuexing'] = $xuexing;
		//����
		$_COOKIE['laisuanming']['nian1'] = $nian1;
		$_COOKIE['laisuanming']['yue1'] = $yue1;
		$_COOKIE['laisuanming']['ri1'] = $ri1;
		$_COOKIE['laisuanming']['hh1'] = $hh1;
		$_COOKIE['laisuanming']['mm1'] = $mm1;
		//ũ��
		$_COOKIE['laisuanming']['nian2'] = $nlnian;
		$_COOKIE['laisuanming']['yue2'] = $nlyue;
		$_COOKIE['laisuanming']['ri2'] = $nlri;
		$_COOKIE['laisuanming']['hh2'] = $hh1;
		$_COOKIE['laisuanming']['mm2'] = $mm1;
		$_COOKIE['laisuanming']['sx'] = $sx;
	}
}


//���cookies---clearcookies()
function clearcookies()
{
	 $cookieExpire = time()-3600;
		setcookie ('laisuanming[xing]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[ming]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[xingbie]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[xuexing]', '' , $cookieExpire, '/');
		//����
		setcookie ('laisuanming[nian1]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[yue1]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[ri1]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[hh1]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[mm1]', '' , $cookieExpire, '/');
		//ũ��
		setcookie ('laisuanming[nian2]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[yue2]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[ri2]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[hh2]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[mm2]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[sx]', '' , $cookieExpire, '/');
  setcookie ('laisuanming', '' , $cookieExpire, '/');
}

/**
$pingyin = '';
for($i=0; $i<strlen($str); $i+=2) {
    $pinyin = g(substr($str, $i, 2));
    if($pinyin=='') {
        echo substr($str, $i, 2);
    } 
    if($pinyin!=$pingyin) {
        echo $pinyin . "\n";
        $pingyin = $pinyin;
    }
}
**/
