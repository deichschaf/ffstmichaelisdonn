import React from 'react';
import { Col, Row } from 'react-bootstrap';
import Globalvars from '../../../../../globalvars';
import { ContentVehicleDetailProps } from '../../../../../props/props';
import PictureSourcSet from '../../../../atoms/Picture/SourceSet';
import H2 from '../../../../atoms/Typography/H2';
import H3 from '../../../../atoms/Typography/H3';
import ErrorBoundary from '../../../errorboundary';

const ContentVehicleDetail: React.FC<React.PropsWithChildren<ContentVehicleDetailProps>> = (
  props: ContentVehicleDetailProps
): JSX.Element => {
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
      {details.allgemein !== '' && details.allgemein !== null ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            {details.allgemein}
          </Col>
        </Row>
      ) : (
        <></>
      )}
      {details.img !== '' && details.img !== null ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <PictureSourcSet
              className="picture"
              img={details.img}
              path={Globalvars.getFilePath() + '/fahrzeuge/'}
              images={details.images}
            />
          </Col>
        </Row>
      ) : (
        <></>
      )}
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <H3 label="Fahrzeugdaten" />
        </Col>
      </Row>
      {details.kennzeichen !== '' && details.kennzeichen !== null ? (
        <Row>
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            Kennzeichen:
          </Col>
          <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
            {details.kennzeichen}
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
            {details.bos_kennung}
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
            {details.zugelassen}
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
            {details.motorleistung}
          </Col>
        </Row>
      ) : (
        <></>
      )}
      {details.fahrgestell !== '' && details.fahrgestell !== null ? (
        <Row>
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            Fahrgestell:
          </Col>
          <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
            {details.fahrgestell}
          </Col>
        </Row>
      ) : (
        <></>
      )}
      {details.zulaessiges_gesamtgewicht !== '' && details.zulaessiges_gesamtgewicht !== null ? (
        <Row>
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            Zulässiges Gesamtgewicht:
          </Col>
          <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
            {details.zulaessiges_gesamtgewicht}
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
            {details.aufbau}
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
            {details.ausfahrhoehe}
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
            {details.sitzplaetze}
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
            {details.tank}
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
            {details.beladung_ueber_normal}
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
            {details.besonderheiten}
          </Col>
        </Row>
      ) : (
        <></>
      )}
    </ErrorBoundary>
  );
};
export default ContentVehicleDetail;
