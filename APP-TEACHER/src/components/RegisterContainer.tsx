import './HomeContainer.css';
import { IonButton, IonRouterLink, IonInput, IonItem, IonLabel, useIonAlert,IonCard, IonCardContent,IonText, IonIcon} from '@ionic/react';
import {useState} from 'react';
interface ContainerProps { }

const RegisterContainer: React.FC<ContainerProps> = () => {
  const [ phone_number, setPhone_number ] = useState('');
  const [ phone, setPhone ] = useState('');
  const [ password, setPassword ] = useState('');
  const [ password2, setPassword2 ] = useState('');
  const [ presentAlert ] = useIonAlert();
  function RegisterFrom(){
    // console.log(username);
    presentAlert({
      header: 'Đăng ký thành công',
      message: 'Tài khoản đã đăng ký thành công',
      buttons: ['OK'],
    })
  }
  return (
    <div className="container text-center">
      <IonIcon icon="assets/eclo.svg" color="dark" size="large" className="logo mb-2 mt-5" />
      <IonCard className="Welcome">
        <IonCardContent className="text-center p-0">
          <IonText color="dark" className="text-center fw-bold pt-1 mb-3 fs-2 d-block">Đăng ký</IonText>
          <p>Vui lòng điền đẩy đủ thông tin bên dưới.</p>
          <div className="mb-3 pt-0">
            <IonItem className="from-controll">
              <IonLabel position="floating">Email</IonLabel>
              <IonInput placeholder="Email" type="email" onIonChange={(e:any) => setPhone_number(e.target.value)}></IonInput>
            </IonItem>
            <IonItem className="from-controll">
              <IonLabel position="floating">Điện Thoại</IonLabel>
              <IonInput placeholder="Điện Thoại" type="tel" onIonChange={(e:any) => setPhone(e.target.value)}></IonInput>
            </IonItem>
            <IonItem className="from-controll">
              <IonLabel position="floating">Mật khẩu</IonLabel>
              <IonInput placeholder="Mật khẩu" type="password" onIonChange={(e:any) => setPassword(e.target.value)}></IonInput>
            </IonItem>
            <IonItem className="from-controll">
              <IonLabel position="floating">Xác nhận mật khẩu</IonLabel>
              <IonInput placeholder="Xác nhận mật khẩu" type="password" onIonChange={(e:any) => setPassword2(e.target.value)}></IonInput>
            </IonItem>
          </div>
          <div className="text-start p-2">
            <p><strong className="text-danger">*</strong> Bằng cách ấn nút <strong>"ĐĂNG KÝ"</strong> tôi đồng ý với Điều khoản sử dụng và Chính sách bảo mật của ECLO CO.,LTD</p>
          </div>
          <div className="ps-4 pe-4 pb-2 pt-2">
            <IonButton onClick={RegisterFrom} shape="round" expand="block">Đăng ký</IonButton>
            <IonRouterLink className="fw-bold mt-4 d-block" routerLink="/Login">Tôi đã có tài khoản</IonRouterLink>
          </div>
          <div className="d-flex justify-content-between pe-3 ps-3 pb-3">
          </div>
        </IonCardContent>
      </IonCard>
      <div className="copyright">
        © 2023 Bản quyền và thiết kế bởi ECLO CO.,LTD
      </div>
    </div>
  );
};

export default RegisterContainer;
