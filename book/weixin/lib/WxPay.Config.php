<?php
/**
* 	�����˺���Ϣ
*/

class WxPayConfig
{
	//=======��������Ϣ���á�=====================================
	//
	/**
	 * TODO: �޸���������Ϊ���Լ�������̻���Ϣ
	 * ΢�Ź��ں���Ϣ����
	 * 
	 * APPID����֧����APPID���������ã������ʼ��пɲ鿴��
	 * 
	 * MCHID���̻��ţ��������ã������ʼ��пɲ鿴��
	 * 
	 * KEY���̻�֧����Կ���ο������ʼ����ã��������ã���¼�̻�ƽ̨�������ã�keyi 
	 * APPSECRET�������ʺ�secert����JSAPI֧����ʱ����Ҫ���ã� ��¼����ƽ̨�����뿪�������Ŀ����ã���
	 * ��ȡ��ַ��https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN
	 * @var string
	 */
	const APPID = 'wxcd7483d0d5dcd585';
	const MCHID = '1394379702';
	const KEY = 'longwenqingfeixiangdezhifuhuidal';
	const APPSECRET = 'fcc0897b8d0259324b20d500c13caa77'; 
	
	
	/*���ں�(����������΢�Ź��ں�֧��������΢��֧������������������û�а취��app��ʹ�ã�ֻ��ͨ��ɨ�����js)
	const APPID = 'wx02973d06a74f5360';
	const MCHID = '1232570702';
	const KEY = 'dongguanguoweiwangluokejiyouxian';
	const APPSECRET = 'f6a672f4d86a3fe120f81d38f19ab46b';*/
	
	//=======��֤��·�����á�=====================================
	/**
	 * TODO�������̻�֤��·��
	 * ֤��·��,ע��Ӧ����д����·�������˿��������ʱ��Ҫ���ɵ�¼�̻�ƽ̨���أ�
	 * API֤�����ص�ַ��https://pay.weixin.qq.com/index.php/account/api_cert������֮ǰ��Ҫ��װ�̻�����֤�飩
	 * @var path
	 */
	const SSLCERT_PATH = '../cert/apiclient_cert.pem';
	const SSLKEY_PATH = '../cert/apiclient_key.pem';
	
	//=======��curl�������á�===================================
	/**
	 * TODO���������ô��������ֻ����Ҫ�����ʱ������ã�����Ҫ����������Ϊ0.0.0.0��0
	 * ������ͨ��curlʹ��HTTP POST�������˴����޸Ĵ����������
	 * Ĭ��CURL_PROXY_HOST=0.0.0.0��CURL_PROXY_PORT=0����ʱ����������������Ҫ�����ã�
	 * @var unknown_type
	 */
	const CURL_PROXY_HOST = "0.0.0.0";//"10.152.18.220";
	const CURL_PROXY_PORT = 0;//8080; 
	
	//=======���ϱ���Ϣ���á�===================================
	/**
	 * TODO���ӿڵ����ϱ��ȼ���Ĭ�Ͻ������ϱ���ע�⣺�ϱ���ʱ��Ϊ��1s�����ϱ����۳ɰܡ������׳��쳣����
	 * ����Ӱ��ӿڵ������̣��������ϱ�֮�󣬷���΢�ż��������õ���������������
	 * ���������ϱ���
	 * �ϱ��ȼ���0.�ر��ϱ�; 1.����������ϱ�; 2.ȫ���ϱ�
	 * @var int
	 */
	const REPORT_LEVENL = 1;
}
