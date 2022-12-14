import React, { useState, useEffect } from "react";
import { Col, Row, Button, Modal } from "react-bootstrap";
import { useParams, useNavigate, Link } from "react-router-dom";
import { useOrder } from "../../../hooks/useOrder";

import statusIsReceived from "../../../assets/images/order-received.png";
import statusIsReceivedAlt from "../../../assets/images/order-received-alt.png";
import statusIsPreparing from "../../../assets/images/kitchen-prep.png";
import statusIsPreparingAlt from "../../../assets/images/order-preparing-alt.png";
import statusIsOtw from "../../../assets/images/rider-on-the-way.png";
import statusIsOtwAlt from "../../../assets/images/order-otw-alt.png";
import statusIsDelivered from "../../../assets/images/delivered.png";
import statusIsDeliveredAlt from "../../../assets/images/order-delivered-alt.png";

import styles from "./StatusContent.module.scss";
import Lottie from "lottie-react";
import updateSuccess from "../../../assets/update-success.json";
import Chat from "./Chat";

import Pusher from "pusher-js";
import * as PusherTypes from "pusher-js";

var presenceChannel: PusherTypes.PresenceChannel;
const PUSHER_KEY = process.env.REACT_APP_PUSHER_KEY || "";

const pusher = new Pusher(PUSHER_KEY, {
  cluster: "ap1",
});
// Pusher.logToConsole = true;

interface ContainerProps {}

type ForPreparingItem = {
  created_at: string;
  customer_id: string;
  customer_mobile: string;
  customer_name: string;
  order_address: string;
  order_email: string;
  order_mobile: string;
  order_status?: string;
  otw_at: string;
  payment_type: string;
  plate_number: string;
  restaurant_name: string;
  restaurant_id: string;
  updated_at: string;
  rider_id: string;
  rider_vehicle_model: string;
  id: number;
  restaurant_address: string;
  total_amount: number;
};

type TChat = {
  created_at?: string;
  from?: string;
  message?: string;
  to?: string;
};

const StatusContent: React.FC<ContainerProps> = ({}) => {
  const [status, setStatus] = useState<ForPreparingItem>();
  const [updateModalShow, setUpdateModalShow] = useState(false);
  const [restaurantChat, setRestaurantChat] = useState<TChat[]>();
  const [restaurantChatroom, setRestaurantChatroom] = useState("");
  const [isGuest, setIsGuest] = useState(false);
  const { updateOrder, getOrdersById } = useOrder();
  const [isloaded, setIsloaded] = useState(false);
  const navigate = useNavigate();

  const [order, setOrder] = useState<ForPreparingItem | null>(null);
  // const [orderStatus, setOrderStatus] = useState<string>("");

  // Get the params from the url
  const { id } = useParams();

  // const initializeOrderChannel = (orderRoom: string) => {
  //   console.log("jejejeje");
  //   const channel = pusher.subscribe(orderRoom);
  //   channel.bind("Order-Updated-Event", (data: any) => {
  //     const parsedData = JSON.parse(data.message);
  //     const status = parsedData.status;

  //     // setOrder({ ...parsedData, order_status: status });
  //     setOrderStatus(status);

  //     if (status == "canceled" || status == "delivered") {
  //       pusher.unsubscribe(orderRoom);
  //     }
  //   });
  // };

  const loadReceivedOrder = async () => {
    const response = await getOrdersById(id);
    // *console.log("getOrdersById response", !!response.guest_id);
    setStatus(response);
    setOrder(response);
    setIsGuest(!!response.guest_id);
    // *console.log("@@@", response);

    const orderRoom = `Order-Channel-${response.id}`;
    initializeOrderChannel(orderRoom);

    if (!!!response.guest_id) {
      // Initialize chat channel for merchant
      // console.log("customer");
      const merchantChatRoom = `ChatRoom-C${response.customer_id}-M${response.restaurant_id}`;
      initializeChatChannel(
        merchantChatRoom,
        setRestaurantChat,
        setRestaurantChatroom
      );
      setIsloaded(true);
    } else {
      // Initialize chat channel for merchant
      const merchantChatRoom = `ChatRoom-G${response.guest_id}-M${response.restaurant_id}`;
      initializeChatChannel(
        merchantChatRoom,
        setRestaurantChat,
        setRestaurantChatroom
      );
      setIsloaded(true);
    }
  };

  const initializeChatChannel = (
    chatRoom: string,
    setChat: any,
    setChatroom: any
  ) => {
    setChatroom(chatRoom);
    const channelChat = pusher.subscribe(chatRoom);
    channelChat.bind("Message-Event", (data: any) => {
      const chatData = JSON.parse(data.message);
      // *console.log("New restaurant chat!", chatData);
      setChat((current: any) => {
        if (current?.length) {
          return [...current, chatData];
        }
        return [chatData];
      });
    });
  };

  const initializeOrderChannel = (orderRoom: string) => {
    const channel = pusher.subscribe(orderRoom);
    channel.bind("Order-Updated-Event", (data: any) => {
      const parsedData = JSON.parse(data.message);
      const status = parsedData.status;

      setOrder({ ...parsedData, order_status: status });
    });
  };

  const handleAccept = async (id: any) => {
    // *console.log(id);
    setUpdateModalShow(true);
    const response = await updateOrder(id, "preparing");
    // alert("updated status preparing successfully");
    // navigate("/account/for-delivery");
  };

  useEffect(() => {
    loadReceivedOrder();
  }, []);

  return (
    <div className={styles.container}>
      <div className="text-center">
        <div className={styles.title}>
          <h3>Order Tracker</h3>
        </div>

        <Row md={4} xs={1}>
          <Col className={styles.statusContent}>
            <div className={styles.status}>
              {/* <img src={statusIsReceived} alt="" />
              <p>Order Received</p> */}
              <div className={styles.imgContainer}>
                <img src={statusIsReceived} alt="" />
                {order?.order_status === "received" && (
                  <img
                    src={statusIsReceivedAlt}
                    alt=""
                    className={styles.altImg}
                  />
                )}
                <p>Order Received</p>
              </div>
            </div>
          </Col>
          <Col className={styles.statusContent}>
            <div className={styles.status}>
              <div className={styles.imgContainer}>
                <img src={statusIsPreparing} alt="" />
                {order?.order_status === "preparing" && (
                  <img
                    src={statusIsPreparingAlt}
                    alt=""
                    className={styles.altImg}
                  />
                )}
                <p>Kitchen Preparing ...</p>
              </div>
            </div>
            {order?.order_status === "received" ? (
              <Button
                type="submit"
                onClick={() => handleAccept(status?.id)}
                className={styles.activateBtn}
              >
                Activate
              </Button>
            ) : null}
          </Col>
          <Col className={styles.statusContent}>
            <div className={styles.status}>
              <div className={styles.imgContainer}>
                <img src={statusIsOtw} alt="" />
                {order?.order_status === "otw" && (
                  <img src={statusIsOtwAlt} alt="" className={styles.altImg} />
                )}
                <p>Rider on its way</p>
              </div>
            </div>
          </Col>
          <Col className={styles.statusContent}>
            <div className={styles.status}>
              <div className={styles.imgContainer}>
                <img src={statusIsDelivered} alt="" />
                {order?.order_status === "delivered" && (
                  <img
                    src={statusIsDeliveredAlt}
                    alt=""
                    className={styles.altImg}
                  />
                )}
                <p>Delivered</p>
              </div>
            </div>
          </Col>
        </Row>
      </div>
      <div className={styles.chatContainer}>
        {isloaded && (
          <Chat
            orderId={id}
            restaurantChat={restaurantChat}
            setRestaurantChat={setRestaurantChat}
            isGuest={isGuest}
            restaurantChatroom={restaurantChatroom}
          />
        )}
      </div>
      <UpdateSuccessModal
        show={updateModalShow}
        onHide={() => setUpdateModalShow(false)}
        setUpdateModalShow={setUpdateModalShow}
        updateModalShow={updateModalShow}
      />
    </div>
  );
};

const UpdateSuccessModal = (props: any) => {
  const { setUpdateModalShow } = props;

  const handleClick = () => {
    setUpdateModalShow(false);
  };
  return (
    <Modal {...props} aria-labelledby="contained-modal-title-vcenter" centered>
      <Modal.Body>
        <div className={`text-center p-4`}>
          <Lottie animationData={updateSuccess} loop={true} />
          <p className="mt-4" style={{ fontWeight: "400" }}>
            Updated status preparing successfully
          </p>

          <Link
            to="/account/for-delivery"
            onClick={handleClick}
            className={`d-inline-block mt-2`}
            style={{
              background: "#e6b325",
              border: "none",
              borderRadius: "5px",
              color: "black",
              fontSize: "16px",
              fontWeight: "300",
              width: "180px",
              padding: "6px",
              textDecoration: "none",
              transition: "all 0.3s ease-in-out",
            }}
          >
            Next
          </Link>
        </div>
      </Modal.Body>
    </Modal>
  );
};

export default StatusContent;
