import { IonContent, IonHeader, IonPage, IonTitle, IonToolbar } from '@ionic/react';
import LoginContainer from '../components/LoginContainer';
import './Home.css';

const Login: React.FC = () => {
  return (
    <IonPage>
      <IonContent fullscreen>
        <LoginContainer />
      </IonContent>
    </IonPage>
  );
};

export default Login;
