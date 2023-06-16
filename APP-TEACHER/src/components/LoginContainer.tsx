import './HomeContainer.css';
import { IonButton, IonRouterLink, IonInput, IonItem, IonLabel,useIonAlert, IonCard, IonCardContent, IonText, IonIcon, useIonLoading} from '@ionic/react';
import {useState, useEffect} from 'react';
import axios from "axios";
import { useHistory } from "react-router-dom";
// import { getToken, removeUserSession , setUserSession } from '../pages/Common';
// import { Router } from '@ionic/router';
interface ContainerProps { }
const LoginContainer: React.FC<ContainerProps> = () => {
  const history = useHistory();
  const [ phone_number, setPhone_number ] = useState('');
  const [ password, setPassword ] = useState('');
  const [ token, setToken ] = useState('');
  const [ presentAlert ] = useIonAlert();
  const [present, dismiss] = useIonLoading();
  function LoginFrom(e:any){
    // console.log(username);
    present({
        message: 'Loading...',
        spinner: 'circles'
    });
    if (!phone_number) {
        presentAlert({
          header: 'Lỗi',
          message: 'Vui lòng nhập tài khoản',
          buttons: ['OK'],
        })
    }
    else if (!password) {
        presentAlert({
          header: 'Lỗi',
          message: 'Vui lòng nhập mật khẩu',
          buttons: ['OK'],
        })
    }else{
    const loginData = {
        "phone_number": phone_number,
        "password": password
    }

    const api = axios.create({
        baseURL: "https://school.hewo.vn/api"
    })
    api.post("/login_teacher", loginData).then(res => {     
      if(res.data.status=='error'){
        dismiss();
        presentAlert({
          header: 'Lỗi',
          message: res.data.content,
          buttons: ['OK'],
        });
      }
      else if(res.data.status=='success'){
        
        localStorage.setItem("token", res.data.token);
        const token = localStorage.getItem("token");

        console.log(res.data.token);
        dismiss();
        const setUserSession = (token: any) => {
             localStorage.setItem('token', token);
           }
        setUserSession(res.data.token);

        // localStorage.setItem("token", res.data.token);
        history.push("/dashboard");
      }
    }).catch(error=>{
      dismiss();
       presentAlert({
          header: 'Lỗi',
          message: 'không thể kết nối đến máy chủ',
          buttons: ['OK'],
        })
    })
  }
    
  }

  
  return (
    <div className="container h-100 text-center">
      <IonIcon icon="assets/eclo.svg" size="large" className="logo mb-2 mt-5" />
      <IonCard className="Welcome">
        <IonCardContent className="text-center p-0">
          <IonText color="dark" className="text-center fw-bold pt-1 mb-3 fs-2 d-block">Đăng nhập</IonText>
          <p>Vui lòng đăng nhập để sử dụng ứng dụng này.</p>
          <div className="p-0 mb-4 pt-0">
            <IonItem className="from-controll">
              <IonLabel position="floating">Email / Số điện thoại</IonLabel>
              <IonInput placeholder="Email  / Số điện thoại" onIonChange={(e:any) => setPhone_number(e.target.value)}></IonInput>
            </IonItem>
            <IonItem className="from-controll">
              <IonLabel position="floating">Mật khẩu</IonLabel>
              <IonInput placeholder="Mật khẩu" type="password" onIonChange={(e:any) => setPassword(e.target.value)}></IonInput>
            </IonItem>
          </div>
          <div className="ps-4 pe-4 pb-2 pt-2">
            <IonButton onClick={LoginFrom}  shape="round" expand="block">Đăng nhập</IonButton>
            <IonRouterLink className="fw-bold mt-4 d-block " routerLink="/Register">Tôi chưa có tài khoản</IonRouterLink>
            <IonRouterLink className="fw-bold mt-4 d-block " routerLink="/Forgot-Password">Quên mật khẩu?</IonRouterLink>
          </div>
        </IonCardContent>
      </IonCard>
      <div className="copyright">
        © 2023 Bản quyền và thiết kế bởi ECLO CO.,LTD
      </div>
    </div>
  );
};

export default LoginContainer;
