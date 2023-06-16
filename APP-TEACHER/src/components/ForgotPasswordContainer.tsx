import './HomeContainer.css';
import { IonButton, IonRouterLink, IonInput, IonItem, IonLabel, useIonAlert, IonCard, IonCardContent,IonText, IonIcon} from '@ionic/react';
import {useState} from 'react';
interface ContainerProps { }

const ForgotPasswordContainer: React.FC<ContainerProps> = () => {
  const [ phone_number, setPhone_number ] = useState('');
  const [ presentAlert ] = useIonAlert();
  function ForgotPass(){
    // console.log(username);
    presentAlert({
      header: 'Hoàn thành',
      subHeader: 'Quên mật khẩu',
      message: 'Mật khẩu đã được gửi đến email: '+phone_number,
      buttons: ['OK'],
    })
  }
  return (
    <div className="container text-center">
      <IonIcon icon="assets/eclo.svg" color="dark" size="large" className="logo mb-2 mt-5" />
      <IonCard className="Welcome">
        <IonCardContent className="text-center p-0">
          <IonText color="dark" className="text-center fw-bold pt-1 mb-3 fs-2 d-block">Quên mật khẩu</IonText>
          <p>Vui lòng đăng nhập email hoặc số điện thoại để sử dụng đặt lại mật khẩu.</p>
          <div className="p-0 mb-4 pt-0">
            <IonItem className="from-controll">
              <IonLabel position="floating">Email / Số điện thoại</IonLabel>
              <IonInput placeholder="Email  / Số điện thoại" onIonChange={(e:any) => setPhone_number(e.target.value)}></IonInput>
            </IonItem>
          </div>
          <div className="ps-4 pe-4 pb-2 pt-2">
            <IonButton onClick={ForgotPass} shape="round" expand="block">Hoàn tất</IonButton>
            <IonRouterLink className="fw-bold mt-4 d-block " routerLink="/Register">Tôi chưa có tài khoản</IonRouterLink>
            <IonRouterLink className="fw-bold mt-4 d-block " routerLink="/Login">Tôi đã có tài khoản</IonRouterLink>
          </div>
        </IonCardContent>
      </IonCard>
      <div className="copyright">
        © 2023 Bản quyền và thiết kế bởi ECLO CO.,LTD
      </div>
    </div>
  );
};

export default ForgotPasswordContainer;
