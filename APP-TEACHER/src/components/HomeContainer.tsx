import './HomeContainer.css';
import { IonButton, IonRouterLink, IonCard, IonCardContent, IonIcon} from '@ionic/react';
import { useHistory } from "react-router-dom";
import logoLight from '/assets/eclo.svg';
import logodark from '/assets/eclo-dark.svg';
// import { getToken, removeUserSession , setUserSession } from '../pages/Common';
interface ContainerProps { }

const HomeContainer: React.FC<ContainerProps> = () => {
  const history = useHistory();
  const handleLogout = () => {
    const removeUserSession = () => {
         localStorage.removeItem('token');
       }
    removeUserSession();
    history.push('/');
  }
  return (
    <div className="container">
      <p>test</p>
      <input type="button" onClick={handleLogout} value="Logout" />
    </div>
  );
};

export default HomeContainer;
