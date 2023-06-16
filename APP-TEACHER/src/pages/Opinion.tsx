import {
  IonButtons,
  IonContent,
  IonHeader,
  IonMenuButton,
  IonPage,
  IonTitle,
  IonToolbar,
  IonCard,
  IonCardContent,
  IonFab,
  IonFabList,
  IonFabButton,
  IonIcon,
  IonButton,
  IonModal,
  IonLabel,
  IonInput,
  IonTextarea,
  IonCol,
  IonBackButton,
} from "@ionic/react";
import React, { useRef } from "react";
// import { useParams } from 'react-router';
// import ExploreContainer from '../components/ExploreContainer';
import "./Opinion.css";

import {
  IonItem,
  IonGrid,
  IonRow,
  IonCardHeader,
  IonCardTitle,
  IonCardSubtitle,
  IonSearchbar,
  createAnimation,
} from "@ionic/react";
// import { IonList, IonSelect, IonSelectOption, IonIcon, IonThumbnail } from '@ionic/react';
// import { IonReactRouter } from '@ionic/react-router';
import { Link } from "react-router-dom";
import {
  chevronUpCircle,
  closeOutline,
  duplicateOutline,
  trashOutline,
} from "ionicons/icons";
 
// import Menu from '../components/Menu';

const Opinion: React.FC = () => {
  // const data = ['Amsterdam', 'Buenos Aires', 'Cairo', 'Geneva', 'Hong Kong', 'Istanbul', 'London', 'Madrid', 'New York', 'Panama City'];
  // let [results, setResults] = useState([...data]);

  // const handleChange = (ev: Event) => {
  //   let query = "";
  //   const target = ev.target as HTMLIonSearchbarElement;
  //   if (target) query = target.value!.toLowerCase();

  //   setResults(data.filter(d => d.toLowerCase().indexOf(query) > -1));
  // }
  const modal = useRef<HTMLIonModalElement>(null);

  function dismiss() {
    modal.current?.dismiss();
  }

  const enterAnimation = (baseEl: HTMLElement) => {
    const root = baseEl.shadowRoot;

    const backdropAnimation = createAnimation()
      .addElement(root?.querySelector("ion-backdrop")!)
      .fromTo("opacity", "0.01", "var(--backdrop-opacity)");

    const wrapperAnimation = createAnimation()
      .addElement(root?.querySelector(".modal-wrapper")!)
      .keyframes([
        { offset: 0, opacity: "0", transform: "scale(0)" },
        { offset: 1, opacity: "0.99", transform: "scale(1)" },
      ]);

    return createAnimation()
      .addElement(baseEl)
      .easing("ease-out")
      .duration(500)
      .addAnimation([backdropAnimation, wrapperAnimation]);
  };

  const leaveAnimation = (baseEl: HTMLElement) => {
    return enterAnimation(baseEl).direction("reverse");
  };
  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            {/* <IonMenuButton /> */}
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Đóng góp ý kiến</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
        <IonCard className="card-home">
          <IonCardContent className="card-content">
            <IonGrid>
              <IonRow className="row">
                <IonSearchbar
                  style={{ textAlign: "start" }}
                  className="searchbar"
                  debounce={1000}
                  // onIonChange={(ev) => handleChange(ev)}
                ></IonSearchbar>

                {/* <IonList>
                  {results.map((result) => (
                    <IonItem>{result}</IonItem>
                  ))}
                </IonList> */}
                {/* <IonCol>
                  <IonLabel className="lable-name">Họ và tên :</IonLabel>
                </IonCol>
                <IonCol className="tt" size="7">
                  <h5>Nguyễn Văn A</h5>
                </IonCol> */}
              </IonRow>
            </IonGrid>
          </IonCardContent>
        </IonCard>
        <Link to="/opinionDetail">
          <IonItem button detail={true} className="list-item">
            <IonCardHeader style={{ padding: "10px" }}>
              <IonCardTitle className="title-card">
                Tình học bạo lực học đường tại trường học ABC
              </IonCardTitle>
              <IonCardSubtitle>11/02/2023</IonCardSubtitle>
            </IonCardHeader>
          </IonItem>
        </Link>
        <Link to="/opinionDetail">
          <IonItem button detail={true} className="list-item">
            <IonCardHeader style={{ padding: "10px" }}>
              <IonCardTitle className="title-card">
                Tình học bạo lực học đường tại trường học ABC
              </IonCardTitle>
              <IonCardSubtitle>11/02/2023</IonCardSubtitle>
            </IonCardHeader>
          </IonItem>
        </Link>
        <Link to="/opinionDetail">
          <IonItem button detail={true} className="list-item">
            <IonCardHeader style={{ padding: "10px" }}>
              <IonCardTitle className="title-card">
                Tình học bạo lực học đường tại trường học ABC
              </IonCardTitle>
              <IonCardSubtitle>11/02/2023</IonCardSubtitle>
            </IonCardHeader>
          </IonItem>
        </Link>
        <Link to="/opinionDetail">
          <IonItem button detail={true} className="list-item">
            <IonCardHeader style={{ padding: "10px" }}>
              <IonCardTitle className="title-card">
                Tình học bạo lực học đường tại trường học ABC
              </IonCardTitle>
              <IonCardSubtitle>11/02/2023</IonCardSubtitle>
            </IonCardHeader>
          </IonItem>
        </Link>

        <IonFab slot="fixed" vertical="bottom" horizontal="end">
          <IonFabButton>
            <IonIcon size="large" icon={chevronUpCircle}></IonIcon>
          </IonFabButton>
          <IonFabList side="top">
            <IonFabButton id="open-modal">
              <IonIcon color="success" icon={duplicateOutline}></IonIcon>
            </IonFabButton>
            <IonFabButton>
              <IonIcon color="danger" icon={trashOutline}></IonIcon>
            </IonFabButton>
          </IonFabList>
        </IonFab>

        <IonModal
          id="example-modal"
          ref={modal}
          trigger="open-modal"
          enterAnimation={enterAnimation}
          leaveAnimation={leaveAnimation}
          style={{alignItems: "start", marginTop:"20px"}}
          
        >
          <IonContent>
            <IonToolbar >
              <IonTitle color={"white"} style={{ textAlign: "center", fontStyle:"bold" }}>
                THÊM GÓP Ý
              </IonTitle>
              <IonButtons slot="end">
                <IonButton onClick={() => dismiss()}>
                  <IonIcon color={"white"} icon={closeOutline}></IonIcon>
                </IonButton>
              </IonButtons>
            </IonToolbar>
            <IonCard color={"light"} >
              <IonCardContent style={{ height: "100%" }}>
                {/* <IonItem fill="outline">
                  <IonInput readonly>Phụ huynh của em: Nguyễn Văn A</IonInput>
                </IonItem> */}
                <IonItem
                  fill="outline"
                  style={{ width: "100%", marginTop: "20px" }}
                >
                  <IonLabel position="floating" className="ps-2">Tiêu đề góp ý</IonLabel>
                  <IonInput placeholder="Tiêu đề góp ý" className="ps-2"></IonInput>
                </IonItem>

                <IonItem
                  fill="outline"
                  style={{ width: "100%", marginTop: "20px" }}
                >
                  <IonLabel position="floating" className="ps-2">Nội dung góp ý</IonLabel>
                  {/* <div style={{height:"200px"}}> */}
                  <IonTextarea placeholder="Nội dung góp ý" className="ps-2"></IonTextarea>

                  {/* </div> */}
                </IonItem>

                <IonRow
                  class="row-btn"
                  style={{ textAlign: "center", marginTop: "20px" }}
                >
                  <IonCol>
                    <IonButton color="success" style={{ width: "110px" }}>
                      GÓP Ý
                    </IonButton>
                  </IonCol>
                  <IonCol>
                    <IonButton onClick={() => dismiss()} color="danger" style={{ width: "110px" }}>
                      CANCEL
                    </IonButton>
                  </IonCol>
                </IonRow>
              </IonCardContent>
            </IonCard>
          </IonContent>
        </IonModal>
      </IonContent>
      {/* <FooterBar></FooterBar> */}
    </IonPage>
  );
};

export default Opinion;
