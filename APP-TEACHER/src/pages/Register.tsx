import { IonContent, IonHeader, IonPage, IonTitle, IonToolbar} from '@ionic/react';
import RegisterContainer from '../components/RegisterContainer';
import './Home.css';

const Register: React.FC = () => {
  return (
    <IonPage>
      <IonContent fullscreen>
        <RegisterContainer />
      </IonContent>
    </IonPage>
  );
};

export default Register;
