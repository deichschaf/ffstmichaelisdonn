import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentVehicleDetailFloDithProps } from '../../../../../props/props';
import H2 from '../../../../atoms/Typography/H2';
import H3 from '../../../../atoms/Typography/H3';
import ErrorBoundary from '../../../errorboundary';
import ContentArrayString from '../ContentArrayString';
import PhotoInformation from './components/PhotoInformation';
import VehicleProcessOverview from './components/VehicleProcessOverview';

const ContentVehicleDetailFloDith: React.FC<
  React.PropsWithChildren<ContentVehicleDetailFloDithProps>
> = (props: ContentVehicleDetailFloDithProps): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.verhicledetail === 'undefined') {
    return <></>;
  }
  const details = props.data.verhicledetail;
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <H2 label={details.fahrzeug} />
        </Col>
      </Row>
      <Row>
        <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
          {details.allgemein !== '' && details.allgemein !== null ? (
            <Row>
              <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
                <ContentArrayString content={details.allgemein} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.img !== '' && details.img !== null ? (
            <PhotoInformation
              img={details.img}
              images={details.images}
              fotograph={details.fotograph}
              title={details.image_title}
              description={details.image_description}
            />
          ) : (
            <></>
          )}
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <H3 label="Fahrzeugdaten" />
            </Col>
          </Row>
          {details.typ !== '' && details.typ !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                Fahrzeugtyp:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.typ} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.kennzeichen !== '' && details.kennzeichen !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                Kennzeichen:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.kennzeichen} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.bos_kennung !== '' && details.bos_kennung !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                BOS Kennung:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.bos_kennung} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.baujahr !== '' && details.baujahr !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                Baujahr:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.baujahr} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.zugelassen !== '' && details.zugelassen !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                Zugelassen:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.zugelassen} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.motorleistung !== '' && details.motorleistung !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                Motorleistung:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.motorleistung} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.fahrgestell !== '' && details.fahrgestell !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                Hersteller / Modell:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.fahrgestell} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.zulaessiges_gesamtgewicht !== '' &&
          details.zulaessiges_gesamtgewicht !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                Zulässiges Gesamtgewicht:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.zulaessiges_gesamtgewicht} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.aufbau !== '' && details.aufbau !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                Aufbau:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.aufbau} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.ausfahrhoehe !== '' && details.ausfahrhoehe !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                Ausfahrhöhe:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.ausfahrhoehe} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.sitzplaetze !== '' && details.sitzplaetze !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                Sitzplätze:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.sitzplaetze} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.tank !== '' && details.tank !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                Wassertank:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.tank} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.beladung_ueber_normal !== '' && details.beladung_ueber_null !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                Beladung über Normal:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.beladung_ueber_normal} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.besonderheiten !== '' && details.besonderheiten !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                Besonderheiten:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.besonderheiten} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          {details.beschreibungstext !== '' && details.beschreibungstext !== null ? (
            <Row>
              <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
                weitere Informationen:
              </Col>
              <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
                <ContentArrayString content={details.beschreibungstext} />
              </Col>
            </Row>
          ) : (
            <></>
          )}
          <Row>
            <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
              Status:
            </Col>
            <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
              {details.status_dienst}
            </Col>
          </Row>
          <VehicleProcessOverview stationiert={details.stationiert} />
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
          {details.vehicle_images.length > 0 ? (
            <>
              Für weitere Fotos von diesem Fahrzeug bitte klicken!
              {details.vehicle_images.map((item, idx) => (
                <PhotoInformation
                  key={idx}
                  img={item.img}
                  images={item.images}
                  fotograph={item.fotograf}
                  title={item.titel}
                  description={item.beschreibung}
                />
              ))}
            </>
          ) : (
            <></>
          )}
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default ContentVehicleDetailFloDith;
