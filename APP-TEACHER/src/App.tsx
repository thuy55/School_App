import {
  IonApp,
  IonRouterOutlet,
  IonSplitPane,
  setupIonicReact,
} from "@ionic/react";
import { IonReactRouter } from "@ionic/react-router";
import { Redirect, Route } from "react-router-dom";
import Menu from "./components/Menu";
import Leave from "./pages/Leave";
import Home from "./pages/Home";
import News_open from "./pages/News_open";
// import Profile from './pages/ProfileDriver';

import { useState, useEffect } from "react";
import Move from "./pages/Move";
// import PrivateRoute from "./pages/PrivateRoute";
// import PublicRoute from "./pages/PublicRoute";
// import { getToken, removeUserSession , setUserSession } from './pages/Common';

import Welcome from "./pages/Welcome";
import Register from "./pages/Register";
import Login from "./pages/Login";
import ForgotPassword from "./pages/ForgotPassword";

import HealthRecord from "./pages/HealthRecord";
import Opinion from "./pages/Opinion";
import OpinionDetail from "./pages/OpinionDetail";
import Scores from "./pages/Scores";
import Teacher from "./pages/teacher";
import Account from "./pages/Account";
import Debt from "./pages/Debt";
import DebtStudent from "./pages/DebtStudent";
import Cash from "./pages/Cash";
import Dashboard from "./pages/Dashboard";
import Schedule from "./pages/Schedule";
import ScheduleDetail from "./pages/ScheduleDetail";

import AttendanceTeacher from "./pages/AttendanceTeacher";
import Attendance from "./pages/Attendance";
import Meals from "./pages/Meals";
import MealsDetail from "./pages/MealsDetail";
import Notifications from "./pages/Notifications";
import NotificationDetail from "./pages/NotificationDetail";
import LessionPlan from "./pages/LessionPlan";
import ListStudent from "./pages/ListStudent";
import NoteBook from "./pages/NoteBook";
import Note from "./pages/Note";
import Routine from "./pages/Routine";
import RoutineDetail from "./pages/RoutineDetail";
import ProfileDad from "./pages/Profile_dad";
import ProfileMom from "./pages/Profile_mom";
import Profile from "./pages/Profile";
import RegisterBus from "./pages/RegisterBus";
import ProfileDriver from "./pages/ProfileDriver";
import NotificationTeacher from "./pages/NotificationsTeacher";
import NotificationTeacherDetail from "./pages/NotificationTeacherDetail";
/* Core CSS required for Ionic components to work properly */
import "@ionic/react/css/core.css";

/* Basic CSS for apps built with Ionic */
import "@ionic/react/css/normalize.css";
import "@ionic/react/css/structure.css";
import "@ionic/react/css/typography.css";

/* Optional CSS utils that can be commented out */
import "@ionic/react/css/padding.css";
import "@ionic/react/css/float-elements.css";
import "@ionic/react/css/text-alignment.css";
import "@ionic/react/css/text-transformation.css";
import "@ionic/react/css/flex-utils.css";
import "@ionic/react/css/display.css";

/* Theme variables */
import "./theme/variables.css";
import NotificationParent from "./pages/NotificationParent";

setupIonicReact();

const App: React.FC = () => {
  const [authLoading, setAuthLoading] = useState(true);
  useEffect(() => {
    const getToken = () => {
      return localStorage.getItem("token") || null;
    };
    const token = getToken();
    if (!token) {
      return;
    } else {
      setAuthLoading(false);
    }
  }, []);
  const getToken = () => {
      return localStorage.getItem('token') || null;
    }
  function PublicRoute({ component: Component, ...rest }: { component: React.ComponentType<any>, [key: string]: any }) {
    return (
      <Route
      
        {...rest}
        
        render={(props) => !getToken() ? <Component {...props} /> : <Redirect to={{ pathname: '/dashboard' }} />}
      />
    )
  }
  return (
    <IonApp>
      <IonReactRouter>
        <IonSplitPane contentId="main">
          <Menu />
          <IonRouterOutlet id="main">
            <Route exact path="/">
              <Redirect to="/Welcome" />
            </Route>
            <Route path="/leave" exact={true}>
              <Leave />
            </Route>
            <Route path="/Profile" exact={true}>
              <Profile />
            </Route>
            <Route path="/ProfileDad" exact={true}>
              <ProfileDad />
            </Route>
            <Route path="/ProfileMom" exact={true}>
              <ProfileMom />
            </Route>
            <Route path="/ProfileDriver" exact={true}>
              <ProfileDriver />
            </Route>
            <Route path="/news" exact={true}>
              <Home />
            </Route>
            <Route path="/News_open" exact={true}>
              <News_open />
            </Route>
            <Route path="/Move" exact={true}>
              <Move />
            </Route>
            <Route path="/notificationTeacher" exact={true}>
              <NotificationTeacher />
            </Route>

            <Route path="/notificationParent" exact={true}>
              <NotificationParent />
            </Route>
            <Route path="/leave" exact={true}>
              <Leave />
            </Route>
            <Route path="/registerBus" exact={true}>
              <RegisterBus />
            </Route>

            {/* Thúy */}
            <Route path="/dashboard" exact={true}>
              <Dashboard />
            </Route>
            <Route path="/schedule" exact={true}>
              <Schedule />
            </Route>
            <Route path="/healthRecord" exact={true}>
              <HealthRecord />
            </Route>
            <Route path="/scheduleDetail" exact={true}>
              <ScheduleDetail />
            </Route>
            <Route path="/opinion" exact={true}>
              <Opinion />
            </Route>
            <Route path="/opinionDetail" exact={true}>
              <OpinionDetail />
            </Route>
            <Route path="/scores" exact={true}>
              <Scores />
            </Route>
            <Route path="/teacher" exact={true}>
              <Teacher />
            </Route>
            <Route path="/Account" exact={true}>
              <Account />
            </Route>
            <Route path="/Debt" exact={true}>
              <Debt />
            </Route>
            <Route path="/DebtStudent" exact={true}>
              <DebtStudent />
            </Route>
            <Route path="/Cash" exact={true}>
              <Cash />
            </Route>
            <Route path="/lessionPlan" exact={true}>
              <LessionPlan />
            </Route>
            <Route path="/listStudent" exact={true}>
              <ListStudent />
            </Route>
            <Route path="/noteBook" exact={true}>
              <NoteBook />
            </Route>
            <Route path="/note" exact={true}>
              <Note />
            </Route>
            <Route path="/AttendanceTeacher" exact={true}>
              <AttendanceTeacher />
            </Route>

            <Route path="/routine" exact={true}>
              <Routine />
            </Route>
            <Route path="/routineDetail" exact={true}>
              <RoutineDetail />
            </Route>

            {/* Thọ */}
            <Route path="/notificationDetail" exact={true}>
              <NotificationDetail />
            </Route>
            <Route path="/notificationTeacherDetail" exact={true}>
              <NotificationTeacherDetail />
            </Route>
            <Route path="/notifications" exact={true}>
              <Notifications />
            </Route>
            <Route path="/meals" exact={true}>
              <Meals />
            </Route>
            <Route path="/mealsDetail" exact={true}>
              <MealsDetail />
            </Route>
            <Route path="/attendance" exact={true}>
              <Attendance />
            </Route>

            <PublicRoute exact path="/Welcome" component={Welcome} />
            <PublicRoute exact path="/Register" component={Register} />
            <PublicRoute exact path="/Login" component={Login} />
            <PublicRoute
              exact
              path="/Forgot-Password"
              component={ForgotPassword}
            />
            

            {/* <Route path="/Welcome" exact={true}>
              <Welcome />
            </Route>
            <Route path="/Register" exact={true}>
              <Register />
            </Route>
            <Route path="/Login" exact={true}>
              <Login />
            </Route>
            <Route path="/Forgot-Password" exact={true}>
              <ForgotPassword />
            </Route> */}
            {/* <PrivateRoute exact path="/Home" component={Home} /> */}
          </IonRouterOutlet>
        </IonSplitPane>
      </IonReactRouter>
    </IonApp>
  );
};

export default App;
