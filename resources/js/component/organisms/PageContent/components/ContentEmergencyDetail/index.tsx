import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { Circle, MapContainer, Marker, Polygon, TileLayer, Tooltip } from 'react-leaflet';
import L, { LatLngTuple } from 'leaflet';
import { ContentEmergencyDetailProps } from '../../../../../props/props';
import LinkFA from '../../../../atoms/LinkFA';
import GridSimple from '../../../../molecules/GridSimple';
import ErrorBoundary from '../../../errorboundary';
import EmergencyDetailPictureText from './components/EmergencyDetailPictureText';
import EmergencyVehicle from './components/EmergencyVehicle';

const ContentEmergencyDetail: React.FC<React.PropsWithChildren<ContentEmergencyDetailProps>> = (
  props: ContentEmergencyDetailProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.emergencydetail === 'undefined') {
    return <></>;
  }

  const { unitstations } = props.data.emergencyarea;

  const details = props.data.emergencydetail;

  const position = [details.geo_l, details.geo_b] as LatLngTuple;

  const { stmichaelisdonn } = props.data.emergencyarea.area;
  const { ramhusen } = props.data.emergencyarea.area;

  const stmichaelisdonnOptions = { color: 'red' };
  const ramhusenOptions = { color: 'blue' };
  const emergencyPositionOption = { fillColor: 'yellow' };

  const fire = L.divIcon({
    html: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M288 350.1l0 1.9H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L447.3 128.1c-12.3-1-25 3-34.8 11.7c-35.4 31.6-65.6 67.7-87.3 102.8C304.3 276.5 288 314.9 288 350.1zM453.5 163.8c19.7 17.8 38.2 37 55.5 57.7c7.9-9.9 16.8-20.7 26.5-29.5c5.6-5.1 14.4-5.1 20 0c24.7 22.7 45.6 52.7 60.4 81.1c14.5 28 24.2 56.7 24.2 76.9C640 437.9 568.7 512 480 512c-89.7 0-160-74.2-160-161.9c0-26.4 12.7-58.6 32.4-90.6c20-32.4 48.1-66.1 81.4-95.8c5.6-5 14.2-5 19.8 0zM530 433c30-21 38-63 20-96c-2-4-4-8-7-12l-36 42s-58-74-62-79c-30 37-45 58-45 82c0 49 36 78 81 78c18 0 34-5 49-15z"/></svg>',
    className: 'svg_firedepartment',
    iconSize: [24, 40],
    iconAnchor: [12, 40],
  });

  return (
    <ErrorBoundary>
      <GridSimple>
        <Row className="colorchanger">
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12} className="listcol">
            Einsatznummer:
          </Col>
          <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12} className="listcol">
            {details.einsatz_nummer}
          </Col>
        </Row>
        <Row className="colorchanger">
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12} className="listcol">
            Einsatzzeit:
          </Col>
          <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12} className="listcol">
            {details.beginn} -{details.ende}
          </Col>
        </Row>
        <Row className="colorchanger">
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12} className="listcol">
            Einsatzdauer:
          </Col>
          <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12} className="listcol">
            {details.dauer.day > 0 ? <>{details.dauer.day} Tag(e) </> : <></>}
            {details.dauer.std} Stunde(n)
            {details.dauer.min} Minuten
          </Col>
        </Row>
        <Row className="colorchanger">
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12} className="listcol">
            Einsatztyp:
          </Col>
          <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12} className="listcol">
            {details.einsatz_typ === 'uebung' ? <>Übung</> : <>Einsatz</>}
          </Col>
        </Row>
        <Row className="colorchanger">
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12} className="listcol">
            Einsatzort:
          </Col>
          <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12} className="listcol">
            {details.einsatz_ort}
            {details.access_road !== '' && details.access_road !== null ? (
              <div>
                (Der Anfahrtsweg betrug ca.
                {details.access_road})
              </div>
            ) : (
              <></>
            )}
          </Col>
        </Row>
        <Row className="colorchanger">
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12} className="listcol">
            Einsatzart:
          </Col>
          <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12} className="listcol">
            {details.einsatz_art}
          </Col>
        </Row>
        {typeof details.einsatz_beschreibung !== 'undefined' &&
        details.einsatz_beschreibung !== '' &&
        details.einsatz_beschreibung !== null ? (
          <Row className="colorchanger">
            <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12} className="listcol">
              Beschreibung:
            </Col>
            <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12} className="listcol">
              {details.einsatz_beschreibung}
            </Col>
          </Row>
        ) : (
          <></>
        )}
        {typeof details.einsatz_fahrzeuge !== 'undefined' &&
        details.einsatz_fahrzeuge !== '' &&
        details.einsatz_fahrzeuge !== null ? (
          <Row className="colorchanger">
            <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12} className="listcol">
              Ausgerückte Fahrzeuge:
            </Col>
            <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12} className="listcol">
              {details.einsatz_fahrzeuge}
            </Col>
          </Row>
        ) : (
          <></>
        )}
        {details.fahrzeuge.length > 0 ? (
          <Row className="colorchanger">
            <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12} className="listcol">
              Ausgerückte Fahrzeuge:
            </Col>
            <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12} className="listcol">
              <Row>
                {details.fahrzeuge.map((item, idx) => (
                  <Col key={idx} xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                    <EmergencyVehicle
                      key={idx}
                      id={item.id}
                      img={item.img}
                      images={item.images}
                      bos_kennung={item.bos_kennung}
                      fahrzeug={item.fahrzeug}
                    />
                  </Col>
                ))}
              </Row>
            </Col>
          </Row>
        ) : (
          <></>
        )}

        {details.einheiten.length > 0 ? (
          <Row className="colorchanger">
            <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12} className="listcol">
              Eingesetzte Kräfte:
            </Col>
            <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12} className="listcol">
              {details.einheiten.map((item, idx) => (
                <div className="emergencyUnits" key={idx}>
                  {item.link !== '' && item.link !== null ? (
                    <LinkFA key={idx} target="_blank" href={item.link} title={item.unit} />
                  ) : (
                    <>{item.unit}</>
                  )}
                </div>
              ))}
            </Col>
          </Row>
        ) : (
          <></>
        )}

        {details.geo_l !== '' && details.geo_l !== null ? (
          <Row className="colorchanger">
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12} className="listcol">
              <MapContainer
                doubleClickZoom={false}
                closePopupOnClick={false}
                dragging={false}
                trackResize={false}
                touchZoom={false}
                boxZoom={false}
                center={position}
                zoom={13}
                scrollWheelZoom={false}
                className="emergencyarea"
                attributionControl={false}
                zoomControl={false}
              >
                <TileLayer
                  attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                  url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                />
                <Polygon pathOptions={stmichaelisdonnOptions} positions={stmichaelisdonn}>
                  <Tooltip sticky>Sankt Michaelisdonn</Tooltip>
                </Polygon>
                <Polygon pathOptions={ramhusenOptions} positions={ramhusen}>
                  <Tooltip sticky>Ramhusen</Tooltip>
                </Polygon>
                <Circle center={position} pathOptions={emergencyPositionOption} radius={200}>
                  <Tooltip sticky>Ungefährer Einsatzort</Tooltip>
                </Circle>
                {unitstations.map((item, idx) => (
                  <Marker key={idx} icon={fire} position={item.location}>
                    <Tooltip sticky>{item.name}</Tooltip>
                  </Marker>
                ))}
              </MapContainer>
            </Col>
          </Row>
        ) : (
          <></>
        )}
        {typeof details.einsatz_bilder !== 'undefined' &&
        details.einsatz_bilder !== '' &&
        details.einsatz_bilder !== null ? (
          <Row className="colorchanger">
            <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12} className="listcol">
              Einsatzbilder:
            </Col>
            <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12} className="listcol">
              {details.einsatz_bilder}
            </Col>
          </Row>
        ) : (
          <></>
        )}
        {typeof details.einsatz_bericht !== 'undefined' &&
        details.einsatz_bericht !== '' &&
        details.einsatz_bericht !== null ? (
          <Row className="colorchanger">
            <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12} className="listcol">
              Einsatzbericht:
            </Col>
            <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12} className="listcol">
              {details.einsatz_bericht}
            </Col>
          </Row>
        ) : (
          <></>
        )}
      </GridSimple>
      <EmergencyDetailPictureText />
    </ErrorBoundary>
  );
};
export default ContentEmergencyDetail;
