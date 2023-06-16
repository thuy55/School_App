import {
  IonButtons,
  IonAccordion,
  IonAccordionGroup,
  IonItem,
  IonLabel,
  IonContent,
  IonHeader,
  IonMenuButton,
  IonPage,
  IonTitle,
  IonToolbar,
  IonRow,
  IonCol,
  IonAvatar,
  IonCard,
  IonCardContent,
  IonGrid,
  IonSelect,
  IonSelectOption,
  IonInput,
  IonButton,
  IonBackButton,
} from "@ionic/react";

// import { useParams } from "react-router";
// import ExploreContainer from "../components/ExploreContainer";
import "./Debt.css";
import { useEffect, useState } from "react";
import axios from "axios";
import { Link } from "react-router-dom";

const Debt: React.FC = () => {
  const [students, setStudents] = useState([] as any[]);
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id_school = localStorage.getItem("id_school_teacher");
    var id_course = localStorage.getItem("id_course");
    const loginData = {
      token: x,
      id_school_teacher: id_school,
      id_course: id_course,
    };
    api
      .post("/homeroom_student_teacher", loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setStudents(res.data.liststudent);
        }
      })
      .catch((error) => {});
  }, []);

  function handleClickStudent(e: any) {
    const itemId = e.target.id;
    localStorage.removeItem("id_arrange_class");
    localStorage.setItem("id_arrange_class", itemId);
    console.log(itemId);
  }

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            {/* <IonMenuButton /> */}
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Tra cứu công nợ</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent fullscreen className="box_content">
        {/* <IonCard>
          <IonCardContent className="card-content">
            <IonGrid className="py-0">
              <IonRow className="row px-5 align-items-center d-flex">
                <IonCol>
                  <IonLabel className="lable-name">Học kì :</IonLabel>
                </IonCol>
                <IonCol size="7">
                  <div style={{ width: "100%" }}>
                    <IonSelect
                      className="select-name"
                      color="primary"
                      slot="start"
                      interface="popover"
                      placeholder="Chọn học sinh"
                      onIonChange={(e: any) => handleClickStudent(e.target.value)}
                    >
                      {students.map((students, key) => {
                        return (
                          <IonSelectOption key={key} value={students.id}>{students.firstname} {students.lastname}</IonSelectOption>
                        );
                      })}

                     
                    </IonSelect>
                  </div>
                </IonCol>
              </IonRow>
            </IonGrid>
          </IonCardContent>
        </IonCard> */}
        <IonAccordionGroup className="mt-3 mx-3">
          {students.map((students, key) => {
            return (
              <IonAccordion value={students.id_arrange_class} className="mt-3 acc">
                <IonItem slot="header" color="red" className="item-Cash">
                  <div className="item-count bg-color-green">{key + 1}</div>

                  <IonLabel className="fw-bold">
                    {students.firstname} {students.lastname}
                    <p className="mt-2 text-secondary">
                      Mã học sinh: {students.id_student}
                    </p>
                  </IonLabel>
                </IonItem>
                <div className="ion-padding p-0 pe-2" slot="content">
                  <IonRow className="d-flex justify-content-end my-2">
                    <Link to="/DebtStudent">
                      <IonButton
                        onClick={handleClickStudent}
                        key={students.id_arrange_class}
                        id={students.id_arrange_class}
                      >
                        Xem chi tiết
                      </IonButton>
                    </Link>
                  </IonRow>
                </div>
              </IonAccordion>
            );
          })}
        </IonAccordionGroup>
      </IonContent>
    </IonPage>
  );
};

export default Debt;
