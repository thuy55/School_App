import { IonContent, IonHeader, IonPage, IonTitle, IonToolbar} from '@ionic/react';
import ForgotPasswordContainer from '../components/ForgotPasswordContainer';
import './Home.css';

const ForgotPassword: React.FC = () => {
  return (
    <IonPage>
      <IonContent fullscreen>
        <ForgotPasswordContainer />
      </IonContent>
    </IonPage>
  );
};

export default ForgotPassword;
