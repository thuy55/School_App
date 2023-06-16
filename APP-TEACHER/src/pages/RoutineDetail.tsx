import {
  IonAccordion,
  IonAccordionGroup,
  IonButtons,
  IonCard,
  IonCardContent,
  IonCol,
  IonContent,
  IonGrid,
  IonHeader,
  IonIcon,
  IonItem,
  IonLabel,
  IonMenuButton,
  IonPage,
  IonRow,
  IonSearchbar,
  IonSelect,
  IonSelectOption,
  IonTitle,
  IonToolbar,
} from "@ionic/react";
import { starSharp } from "ionicons/icons";

import "./RoutineDetail.css";

const OpinionDetail: React.FC = () => {
  // const diem=

  // }

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            <IonMenuButton />
            {/* <IonBackButton></IonBackButton> */}
          </IonButtons>
          <IonTitle>Chi tiết nề nếp</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
        <IonGrid style={{ marginTop: "10px" }}>
          <IonAccordionGroup className=" p-2">
            <IonAccordion value="first" className="p-1 bg-color bg-color1 mb-2">
              <IonItem slot="header" color="red" className="item-scores bg-y">
                <IonIcon
                  size="3"
                  icon={starSharp}
                  style={{ marginBottom: 1, marginRight: "20px" }}
                ></IonIcon>
                <IonCol size="8">
                  <IonLabel className="ten m-0 ">
                    VỆ SINH
                    <p className="mt-2 text-secondary fw-medium">
                      Chi tiết điểm trừ
                    </p>
                  </IonLabel>
                </IonCol>
                <IonLabel className="diem fs-3 text-danger">-34</IonLabel>
              </IonItem>
              <div className="p-1" slot="content">
                <IonCard className="bg-card">
                  <IonCardContent className="card-content-grid-list m-0 p-0">
                    <div className="row">
                      <div className="col-lg-6 m-0">
                        <div className="timeline p-1 m-0 block bg-y">
                          <div className="tl-item active">
                            <div className="tl-dot b-danger"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-white text-center" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                              
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-primary"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-warning"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger  text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-danger"></div>
                            <div className="tl-content text-danger border-bottom border-danger ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-warning"></div>
                            <div className="ttl-content  w-100 text-danger ">
                              <IonGrid className="grid">
                                  <IonRow className="row">
                                    <IonCol size="5">
                                      <IonLabel className="lable-name">Tổng điểm trừ</IonLabel>
                                    </IonCol>
                                    <IonCol className="tt bg-danger text-white text-center" size="2">
                                    -34
                                  </IonCol>
                                
                                </IonRow>
                              </IonGrid>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </IonCardContent>
                </IonCard>
              </div>
            </IonAccordion>
            <IonAccordion value="2" className="p-1 bg-color bg-color1 mb-2">
              <IonItem slot="header" color="red" className="item-scores bg-y">
                <IonIcon
                  size="3"
                  icon={starSharp}
                  style={{ marginBottom: 1, marginRight: "20px" }}
                ></IonIcon>
                <IonCol size="8">
                  <IonLabel className="ten m-0 ">
                    CHUYÊN CẦN
                    <p className="mt-2 text-secondary fw-medium">
                      Chi tiết điểm trừ
                    </p>
                  </IonLabel>
                </IonCol>
                <IonLabel className="diem fs-3 text-danger">-34</IonLabel>
              </IonItem>
              <div className="p-1" slot="content">
                <IonCard className="bg-card">
                  <IonCardContent className="card-content-grid-list m-0 p-0">
                    <div className="row">
                      <div className="col-lg-6 m-0">
                        <div className="timeline p-1 m-0 block bg-y">
                          <div className="tl-item active">
                            <div className="tl-dot b-danger"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-white text-center" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                              
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-primary"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-warning"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger  text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-danger"></div>
                            <div className="tl-content text-danger border-bottom border-danger ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-warning"></div>
                            <div className="ttl-content  w-100 text-danger ">
                              <IonGrid className="grid">
                                  <IonRow className="row">
                                    <IonCol size="5">
                                      <IonLabel className="lable-name">Tổng điểm trừ</IonLabel>
                                    </IonCol>
                                    <IonCol className="tt bg-danger text-white text-center" size="2">
                                    -34
                                  </IonCol>
                                
                                </IonRow>
                              </IonGrid>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </IonCardContent>
                </IonCard>
              </div>
            </IonAccordion>
            <IonAccordion value="3" className="p-1 bg-color bg-color1 mb-2">
              <IonItem slot="header" color="red" className="item-scores bg-y">
                <IonIcon
                  size="3"
                  icon={starSharp}
                  style={{ marginBottom: 1, marginRight: "20px" }}
                ></IonIcon>
                <IonCol size="8">
                  <IonLabel className="ten m-0 ">
                    TÁC PHONG
                    <p className="mt-2 text-secondary fw-medium">
                      Chi tiết điểm trừ
                    </p>
                  </IonLabel>
                </IonCol>
                <IonLabel className="diem fs-3 text-danger">-34</IonLabel>
              </IonItem>
              <div className="p-1" slot="content">
                <IonCard className="bg-card">
                  <IonCardContent className="card-content-grid-list m-0 p-0">
                    <div className="row">
                      <div className="col-lg-6 m-0">
                        <div className="timeline p-1 m-0 block bg-y">
                          <div className="tl-item active">
                            <div className="tl-dot b-danger"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-white text-center" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                              
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-primary"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-warning"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger  text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-danger"></div>
                            <div className="tl-content text-danger border-bottom border-danger ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-warning"></div>
                            <div className="ttl-content  w-100 text-danger ">
                              <IonGrid className="grid">
                                  <IonRow className="row">
                                    <IonCol size="5">
                                      <IonLabel className="lable-name">Tổng điểm trừ</IonLabel>
                                    </IonCol>
                                    <IonCol className="tt bg-danger text-white text-center" size="2">
                                    -34
                                  </IonCol>
                                
                                </IonRow>
                              </IonGrid>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </IonCardContent>
                </IonCard>
              </div>
            </IonAccordion>
            <IonAccordion value="4" className="p-1 bg-color bg-color1 mb-2">
              <IonItem slot="header" color="red" className="item-scores bg-y">
                <IonIcon
                  size="3"
                  icon={starSharp}
                  style={{ marginBottom: 1, marginRight: "20px" }}
                ></IonIcon>
                <IonCol size="8">
                  <IonLabel className="ten m-0 ">
                    TRẬT TỰ
                    <p className="mt-2 text-secondary fw-medium">
                      Chi tiết điểm trừ
                    </p>
                  </IonLabel>
                </IonCol>
                <IonLabel className="diem fs-3 text-danger">-34</IonLabel>
              </IonItem>
              <div className="p-1" slot="content">
                <IonCard className="bg-card">
                  <IonCardContent className="card-content-grid-list m-0 p-0">
                    <div className="row">
                      <div className="col-lg-6 m-0">
                        <div className="timeline p-1 m-0 block bg-y">
                          <div className="tl-item active">
                            <div className="tl-dot b-danger"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-white text-center" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                              
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-primary"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-warning"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger  text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-danger"></div>
                            <div className="tl-content text-danger border-bottom border-danger ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-warning"></div>
                            <div className="ttl-content  w-100 text-danger ">
                              <IonGrid className="grid">
                                  <IonRow className="row">
                                    <IonCol size="5">
                                      <IonLabel className="lable-name">Tổng điểm trừ</IonLabel>
                                    </IonCol>
                                    <IonCol className="tt bg-danger text-white text-center" size="2">
                                    -34
                                  </IonCol>
                                
                                </IonRow>
                              </IonGrid>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </IonCardContent>
                </IonCard>
              </div>
            </IonAccordion>
            <IonAccordion value="5" className="p-1 bg-color bg-color1 mb-2">
              <IonItem slot="header" color="red" className="item-scores bg-y">
                <IonIcon
                  size="3"
                  icon={starSharp}
                  style={{ marginBottom: 1, marginRight: "20px" }}
                ></IonIcon>
                <IonCol size="8">
                  <IonLabel className="ten m-0 ">
                    SỔ ĐẦU BÀI
                    <p className="mt-2 text-secondary fw-medium">
                      Chi tiết điểm trừ
                    </p>
                  </IonLabel>
                </IonCol>
                <IonLabel className="diem fs-3 text-danger">-34</IonLabel>
              </IonItem>
              <div className="p-1" slot="content">
                <IonCard className="bg-card">
                  <IonCardContent className="card-content-grid-list m-0 p-0">
                    <div className="row">
                      <div className="col-lg-6 m-0">
                        <div className="timeline p-1 m-0 block bg-y">
                          <div className="tl-item active">
                            <div className="tl-dot b-danger"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-white text-center" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                              
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-primary"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-warning"></div>
                            <div className="tl-content ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger  text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-danger"></div>
                            <div className="tl-content text-danger border-bottom border-danger ">
                            <div className="text-primary fs-5 w-100 mt-1">
                                13/5/2018
                              </div>
                              <div className="text-dark">
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              <IonGrid className="grid">
                                <IonRow className="row">
                                  <IonCol size="5">
                                    <IonLabel className="lable-name">18077551 - Nguyen Thanh Thuy</IonLabel>
                                  </IonCol>
                                  <IonCol className="tt bg-danger text-center text-white" size="2">
                                   -8
                                  </IonCol>
                                  <IonCol className="tt" size="5">
                                   không đồng phục
                                  </IonCol>
                                </IonRow>
                              </IonGrid>
                              </div>
                            </div>
                          </div>
                          <div className="tl-item">
                            <div className="tl-dot b-warning"></div>
                            <div className="ttl-content  w-100 text-danger ">
                              <IonGrid className="grid">
                                  <IonRow className="row">
                                    <IonCol size="5">
                                      <IonLabel className="lable-name">Tổng điểm trừ</IonLabel>
                                    </IonCol>
                                    <IonCol className="tt bg-danger text-white text-center" size="2">
                                    -34
                                  </IonCol>
                                
                                </IonRow>
                              </IonGrid>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </IonCardContent>
                </IonCard>
              </div>
            </IonAccordion>
          </IonAccordionGroup>
        </IonGrid>
      </IonContent>
    </IonPage>
  );
};

export default OpinionDetail;
