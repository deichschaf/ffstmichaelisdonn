import { Col, Row } from 'react-bootstrap';
import { WeatherMessageProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';

const WeatherMessages: React.FC<React.PropsWithChildren<WeatherMessageProps>> = (
  props: WeatherMessageProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  function getIcon(id) {
    /**
     * Gewitter
     */
    if (id === 0) {
      return 'wi-thunderstorm';
    }
    /**
     * Wind/Sturm
     */
    if (id === 1) {
      return 'wi-cloudy-windy';
    }
    /**
     * Regen
     */
    if (id === 2) {
      return 'wi-rain';
    }
    /**
     * Schnee
     */
    if (id === 3) {
      return 'wi-snow';
    }
    /**
     * Nebel
     */
    if (id === 4) {
      return 'wi-fog';
    }
    /**
     * Frost
     */
    if (id === 5) {
      return 'wi-snowflake-cold';
    }
    /**
     * Glätte
     */
    if (id === 6) {
      return 'wi-snowflake-cold';
    }
    /**
     * Tauwetter
     */
    if (id === 7) {
      return 'wi-horizon-alt';
    }
    /**
     * Hitze
     */
    if (id === 8) {
      return 'wi-thermometer';
    }
    /**
     * UV
     */
    if (id === 9) {
      return 'wi-solar-eclipse';
    }
    return 'wi-na';
  }
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <div className="headline">
            <Row>
              <Col
                xxl={12}
                xl={12}
                lg={12}
                md={12}
                sm={12}
                xs={12}
                className={`weather${props.data.level}`}
              >
                <i className={`wi ${getIcon(props.data.type)}`} /> {props.data.headline}
              </Col>
            </Row>
          </div>
          <div className="region">
            <Row>
              <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12} className="content_background">
                Bereich: {props.data.region}
              </Col>
            </Row>
          </div>
          <div className="beginn">
            <Row>
              <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12} className="content_background">
                von: {props.data.start} Uhr
              </Col>
            </Row>
          </div>
          <div className="ende">
            <Row>
              <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12} className="content_background">
                bis: {props.data.end} Uhr
              </Col>
            </Row>
          </div>
          <div className="description">
            <Row>
              <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12} className="content_background">
                {props.data.description}
              </Col>
            </Row>
          </div>
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default WeatherMessages;
