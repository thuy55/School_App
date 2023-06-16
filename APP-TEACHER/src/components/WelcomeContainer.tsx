import './HomeContainer.css';
import { IonButton, IonRouterLink, IonCard, IonCardContent, IonIcon} from '@ionic/react';
interface ContainerProps { }

const WelcomeContainer: React.FC<ContainerProps> = () => {
  return (
    <div className="container h-100">
      <img src="/assets/img/home.png" className="home-img" />
      <IonCard className="Welcome">
        <IonCardContent className="text-center p-0">
          <IonIcon icon="/assets/eclo.svg" color="dark" size="large" className="logo mb-4 mt-3" />
          <p>Ứng dụng quản lý trường học ECLO.</p>
          <div className="ps-4 pe-4 pb-2 pt-2 mt-4 mb-3">
            <IonRouterLink className="btn btn-primary w-100 fw-bold rounded-pill pt-3 pb-3" routerLink="/Login">Đăng Nhập</IonRouterLink>
          </div>
          <div className="d-flex justify-content-between pe-3 ps-3 mb-3">
            <IonRouterLink className="fw-bold mt-3" routerLink="/Register">Đăng Ký</IonRouterLink>
            <IonRouterLink className="fw-bold mt-3" routerLink="/forgot-password">Quên mật khẩu?</IonRouterLink>
          </div>
        </IonCardContent>
      </IonCard>
      <div className="copyright">
        © 2023 Bản quyền và thiết kế bởi ECLO CO.,LTD
      </div>
    </div>
  );
};

export default WelcomeContainer;
