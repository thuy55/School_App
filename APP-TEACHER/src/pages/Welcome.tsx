import { IonContent, IonHeader, IonPage, IonTitle, IonToolbar } from '@ionic/react';
import WelcomeContainer from '../components/WelcomeContainer';
import './Home.css';

const Welcome: React.FC = () => {
  return (
    <IonPage>
      <IonContent fullscreen>
        <WelcomeContainer />
      </IonContent>
    </IonPage>
  );
};

export default Welcome;
