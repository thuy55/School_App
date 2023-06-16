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
  IonAlert,
  IonToast,
  IonIcon,
  IonBackButton,
} from "@ionic/react";

// import { useParams } from "react-router";
// import ExploreContainer from "../components/ExploreContainer";
import "./Debt.css";
import { useEffect, useState } from "react";
import axios from "axios";
import { closeCircleOutline, key } from "ionicons/icons";

const Debt: React.FC = () => {
  const [student, setStudent] = useState([] as any[]);
  const [firstname, setFirstname] = useState([] as any[]);
  const [lastname, setLastname] = useState([] as any[]);
  const [debt, setDebt] = useState([] as any[]);
  const [sum, setsum] = useState([] as any[]);
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    // var id = localStorage.getItem("id_student");
    var id = localStorage.getItem("id_arrange_class");
    var id_school_teacher = localStorage.getItem("id_school_teacher");

    const loginData = {
      token: x,
      id_arrange_class: id,
      id_school_teacher: id_school_teacher,
    };
    api
      .post(`/tuition_debt_student_teacher/` + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (res.data.content == null) {
            setShowToast(true);
            setDebt([]);
            setStudent(res.data.students.id_student);
            setFirstname(res.data.students.firstname);
            setLastname(res.data.students.lastname);
            setsum(res.data.tong);
          } else {
            setDebt(res.data.content);
            setStudent(res.data.students.id_student);
            setFirstname(res.data.students.firstname);
            setLastname(res.data.students.lastname);
            setsum(res.data.tong);
            console.log(res.data.content);
          }
        }
      })
      .catch((error) => {});
  }, []);
  const [showToast, setShowToast] = useState(false);
  function getMonthDebt(e: any) {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_arrange_class");
    var id_school_teacher = localStorage.getItem("id_school_teacher");
    const loginData = {
      token: x,
      id_arrange_class: id,
      id_school_teacher: id_school_teacher,
    };
    api
      .post(`/tuition_debt_search_teacher/` + e, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (res.data.content == null) {
            setShowToast(true);
            setDebt([]);
            setsum(res.data.tong);
          } else {
            localStorage.removeItem("month_debt");
            localStorage.setItem("month_debt", e);
            setDebt(res.data.content);
            setsum(res.data.tong);
          }
        }
      })
      .catch((error) => {});
  }
  function handleMonthChange(event: any) {
    const value = event.target.value;
    if (value === "") {
      // User clicked "Clear" button
      window.location.reload();
    } else {
      // User selected a specific month
      console.log("Selected month:", value);
    }
  }
  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Công nợ học sinh</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent fullscreen className="box_content">
        <IonToast
          isOpen={showToast}
          message="Không tìm thấy dữ liệu."
          duration={3000}
          onDidDismiss={() => setShowToast(false)}
          position="top"
          color="danger"
          cssClass="my-toast"
          buttons={[
            {
              text: "Đóng",
              role: "cancel",
              handler: () => {
                setShowToast(false);
              },
            },
          ]}
        />

        <IonCard>
          <IonCardContent className="card-content">
            <IonGrid className="py-0">
              {/* {student.map((student, key) => {
                return (
                  <> */}
              <IonRow className="px-2">
                <IonCol>Tên học sinh:</IonCol>
                <IonCol size="8" className="text-dark fw-bold">
                  {firstname} {lastname}
                </IonCol>
              </IonRow>
              <IonRow className="px-2">
                <IonCol>Mã học sinh:</IonCol>
                <IonCol size="8" className="text-dark fw-bold">
                  {student}
                </IonCol>
              </IonRow>
              {/* </>
                );
              })} */}

              <IonRow className=" px-2 align-items-center d-flex">
                <IonCol>
                  <IonLabel className="lable-name">Tháng :</IonLabel>
                </IonCol>
                <IonCol size="8">
                  <div style={{ width: "100%" }}>
                    <IonInput
                      type="month"
                      onInput={handleMonthChange}
                      onIonChange={(e: any) => getMonthDebt(e.target.value)}
                      placeholder="chọn tháng"
                      className="bg-white p-1"
                    ></IonInput>
                  </div>
                </IonCol>
              </IonRow>
              <IonRow className="px-2">
                <IonCol>Tổng công nợ:</IonCol>
                <IonCol size="8" className="text-dark fw-bold">
                  {sum} VNĐ
                </IonCol>
              </IonRow>
            </IonGrid>
          </IonCardContent>
        </IonCard>
        <IonAccordionGroup className="px-3">
          {debt.map((debt, key) => {
            // if (debt.type == "Chưa đóng") {
            return (
              <IonAccordion key={key} className="mt-3 acc">
                <IonItem slot="header" color="red" className="item-Cash ps-0">
                  <div
                    className="item-count ms-2"
                    style={{ backgroundColor: "red" }}
                  >
                    {debt.month}
                  </div>
                  <IonLabel className="fw-bold">
                    {debt.content}
                    <p className="mt-2 text-secondary">
                      Số tiền: {debt.price} vnd
                    </p>
                  </IonLabel>
                </IonItem>
                <div className="ion-padding p-0 pe-2" slot="content">
                  <ol id="accordion" className="rounded-list accordion">
                    <li>
                      <ol>
                        <li>
                          <p className="link">
                            <IonRow className="row text-align-center">
                              <IonCol>
                                <IonLabel className="lable-name">
                                  Nội dung thu :
                                </IonLabel>
                              </IonCol>
                              <IonCol size="7" className="nd">
                                {debt.content}
                              </IonCol>
                            </IonRow>
                          </p>
                        </li>
                        <li>
                          <p className="link">
                            <IonRow className="row text-align-center">
                              <IonCol>
                                <IonLabel className="lable-name">
                                  Số tiền :
                                </IonLabel>
                              </IonCol>
                              <IonCol size="7" className="nd">
                                {debt.price} VND
                              </IonCol>
                            </IonRow>{" "}
                          </p>
                        </li>
                        <li>
                          <p className="link">
                            <IonRow className="row text-align-center">
                              <IonCol>
                                <IonLabel className="lable-name">
                                  Tháng :
                                </IonLabel>
                              </IonCol>
                              <IonCol size="7" className="nd">
                                {debt.month}
                              </IonCol>
                            </IonRow>
                          </p>
                        </li>
                        {/* <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Học kì :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="7" className="nd">
                                  {debt.semester}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li> */}

                        <li>
                          <p className="link">
                            <IonRow className="row text-align-center">
                              <IonCol>
                                <IonLabel className="lable-name">
                                  Trạng thái :
                                </IonLabel>
                              </IonCol>
                              <IonCol size="7" className="nd">
                                {debt.type}
                              </IonCol>
                            </IonRow>
                          </p>
                        </li>
                      </ol>
                    </li>
                  </ol>
                </div>
              </IonAccordion>
            );
            // } else {
            //   return (
            //     <IonAccordion key={key} className="mt-3 acc">
            //       <IonItem slot="header" color="red" className="item-Cash ps-0">
            //         <div
            //           className="item-count ms-2"
            //           style={{ backgroundColor: "#31e631" }}
            //         >
            //           {debt.month}
            //         </div>
            //         <IonLabel className="fw-bold">
            //           {debt.content}
            //           <p className="mt-2 text-secondary">
            //             Số tiền: {debt.price} vnd
            //           </p>
            //         </IonLabel>
            //       </IonItem>
            //       <div className="ion-padding p-0 pe-2" slot="content">
            //         <ol id="accordion" className="rounded-list accordion">
            //           <li>
            //             <ol>
            //               <li>
            //                 <p className="link">
            //                   <IonRow className="row text-align-center">
            //                     <IonCol>
            //                       <IonLabel className="lable-name">
            //                         Nội dung thu :
            //                       </IonLabel>
            //                     </IonCol>
            //                     <IonCol size="7" className="nd">
            //                       {debt.content}
            //                     </IonCol>
            //                   </IonRow>
            //                 </p>
            //               </li>
            //               <li>
            //                 <p className="link">
            //                   <IonRow className="row text-align-center">
            //                     <IonCol>
            //                       <IonLabel className="lable-name">
            //                         Số tiền :
            //                       </IonLabel>
            //                     </IonCol>
            //                     <IonCol size="7" className="nd">
            //                       {debt.price} VND
            //                     </IonCol>
            //                   </IonRow>{" "}
            //                 </p>
            //               </li>
            //               <li>
            //                 <p className="link">
            //                   <IonRow className="row text-align-center">
            //                     <IonCol>
            //                       <IonLabel className="lable-name">
            //                         Tháng :
            //                       </IonLabel>
            //                     </IonCol>
            //                     <IonCol size="7" className="nd">
            //                       {debt.month}
            //                     </IonCol>
            //                   </IonRow>
            //                 </p>
            //               </li>
            //               {/* <li>
            //                 <p className="link">
            //                   <IonRow className="row text-align-center">
            //                     <IonCol>
            //                       <IonLabel className="lable-name">
            //                         Học kì :
            //                       </IonLabel>
            //                     </IonCol>
            //                     <IonCol size="7" className="nd">
            //                       {debt.semester}
            //                     </IonCol>
            //                   </IonRow>
            //                 </p>
            //               </li> */}

            //               <li>
            //                 <p className="link">
            //                   <IonRow className="row text-align-center">
            //                     <IonCol>
            //                       <IonLabel className="lable-name">
            //                         Trạng thái :
            //                       </IonLabel>
            //                     </IonCol>
            //                     <IonCol size="7" className="nd">
            //                       {debt.type}
            //                     </IonCol>
            //                   </IonRow>
            //                 </p>
            //               </li>
            //             </ol>
            //           </li>
            //         </ol>
            //       </div>
            //     </IonAccordion>
            //   );
            // }
          })}
        </IonAccordionGroup>
      </IonContent>
      {/* <FooterBar></FooterBar> */}
    </IonPage>
  );
};

export default Debt;
