import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { useParams } from 'react-router';
import Select from 'react-select';
import Input from '../../../component/atoms/Form/Input/Input';
import InputDate from '../../../component/atoms/Form/Input/InputDate';
import InputTime from '../../../component/atoms/Form/Input/InputTime';
import TextareaEditor from '../../../component/atoms/Form/TextareaEditor';
import ToggleSwitch from '../../../component/atoms/Form/ToggleSwitch';
import PageHeadline from '../../../component/atoms/PageHeadline';
import { getCookie, getCSRFToken } from '../../../component/component_helper';
import GridSimple from '../../../component/molecules/GridSimple';
import LoadingAlertBox from '../../../component/molecules/LoadingAlertBox';
import SaveInfoError from '../../../component/molecules/SaveInfoError';
import SaveLine from '../../../component/molecules/SaveLine';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { EmergencyAddEditComponentProps } from '../../../props/props';
import EmergencyAlarmMailMessage from '../modules/EmergencyAlarmMailMessage';
import EmergencyGetKoorginates from '../modules/EmergencyGetKoorginates';
import EmergencyMap from '../modules/EmergencyMap';

const EmergencyActionAddEditComponent: React.FC<
  React.PropsWithChildren<EmergencyAddEditComponentProps>
> = (props: EmergencyAddEditComponentProps): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [getEditType, setEditType] = useState<string>('hinzufügen');
  const [errorText, setErrorText] = useState<any>(null);
  const [responseText, setResponseText] = useState<any>(null);
  const [getId, setId] = useState<number>(0);
  const [getEmergencyDefinitionId, setEmergencyDefinitionId] = useState<number>(0); // check
  const [getAlarmEmailId, setAlarmEmailId] = useState<number>(0);
  const [getEraseHelp, setEraseHelp] = useState(false); // check
  const [getStartDate, setStartDate] = useState<string>(''); // check
  const [getStartTime, setStartTime] = useState<string>('00:00'); // check
  const [getEndDate, setEndDate] = useState<string>(''); // check
  const [getEndTime, setEndTime] = useState<string>('00:00'); // check
  const [getEmergencyScenario, setEmergencyScenario] = useState<string>(''); // check
  const [getEmergencyPlace, setEmergencyPlace] = useState<string>(''); // check
  const [getEmergencyType, setEmergencyType] = useState<number>(0); // check
  const [getEmergencyDescription, setEmergencyDescription] = useState<string>(''); // check
  const [getEmergencyDescriptionIntern, setEmergencyDescriptionIntern] = useState<string>(''); // check
  const [getEmergencyUnitDescription, setEmergencyUnitDescription] = useState<string>(''); // check
  // todo youtube
  const [getEmergencyAlarmType, setEmergencyAlarmType] = useState<string>('einsatz'); // check
  const [getActive, setActive] = useState(true); // check
  const [getMaliciousAlarm, setMaliciousAlarm] = useState(false); // check
  const [getFalseAlarm, setFalseAlarm] = useState(false); // check
  const [getEmergencyAlarmChief, setEmergencyAlarmChief] = useState(true); // check
  const [getEmergencyAlarmGroup, setEmergencyAlarmGroup] = useState(true); // check
  const [getEmergencyAlarmFull, setEmergencyAlarmFull] = useState(true); // check
  const [getIsEmergencyAlarm, setIsEmergencyAlarm] = useState(true);
  const [getEmergencyLon, setEmergencyLon] = useState<number>(0);
  const [getEmergencyLat, setEmergencyLat] = useState<number>(0);
  const [getNewsId, setNewsId] = useState<number>(0);
  const [getEmergencyPressText, setEmergencyPressText] = useState<string>(''); // check
  const [getEmergencyPress, setEmergencyPress] = useState<string>(''); // check
  const [getEmergencyVehicle, setEmergencyVehicle] = useState<any>([]);
  const [getEmergencyUnits, setEmergencyUnits] = useState<any>([]);
  const [getSelectValues, setSelectValues] = useState<any>(null);
  const [getAlarmMailResponse, setAlarmMailResponse] = useState<any>([]);
  const [getDateNow, setDateNow] = useState<string>('');
  const [getTimeNow, setTimeNow] = useState<string>('');

  const { id } = useParams();

  function getNewPath() {
    const path = window.location.pathname;
    return path.replace('add', 'overview');
  }

  function CheckResponse(data) {
    if (data.success === true) {
      setLoading(false);
      setResponseText('Erfolgreich gespeichert!');
      setTimeout(() => {
        window.location.href = getNewPath();
      }, 3000);
    } else {
      setErrorText(data.errorMessage);
    }
  }

  function setSelectedValue(id, options) {
    for (let i = 0; i < options.length; i += 1) {
      if (options[i].id === id) {
        return { label: options[i].label, value: options[i].value };
      }
    }
    return { label: '', value: '' };
  }

  function setMultiSelectedValue(id, options) {
    const arr = [];
    for (let i = 0; i < options.length; i += 1) {
      if (options[i].id === id) {
        arr.push({ label: options[i].label, value: options[i].value } as never);
      }
    }
    return arr;
  }

  function setCatchError(err) {
    setErrorText(err);
  }

  function makeDefaultFireData(data) {
    setEmergencyVehicle(data.default_vehicles);
    setEmergencyUnits(data.default_units);
  }

  function funcEmergencyData(data) {
    setId(data.id);
    setAlarmEmailId(data.alarm_email_id);
    setEmergencyDefinitionId(data.emergency_definition_id);
    setEmergencyScenario(data.emergency_scenario);
    setActive(data.active);
    setMaliciousAlarm(data.malicious_alarm);
    setFalseAlarm(data.false_alarm);
    setEraseHelp(data.erase_help);
    setStartDate(data.start_date);
    setStartTime(data.start_time);
    setEndDate(data.end_date);
    setEndTime(data.end_time);
    setEmergencyPlace(data.place);
    setEmergencyType(data.type);
    setEmergencyDescription(data.description);
    setEmergencyDescriptionIntern(data.description_intern);
    setEmergencyUnitDescription(data.unit_description);
    setEmergencyAlarmType(data.alarm_type);
    setEmergencyAlarmChief(data.alarm_chief);
    setEmergencyAlarmGroup(data.alarm_group);
    setEmergencyAlarmFull(data.alarm_full);
    setEmergencyLon(data.lon);
    setEmergencyLat(data.lat);
    setNewsId(data.news_id);
    setEmergencyPressText(data.press_text);
    setEmergencyPress(data.press);
    setEmergencyVehicle(data.vehicle);
    setEmergencyUnits(data.units);
    setIsEmergencyAlarm(data.is_alarm);
  }

  function funcAlarmEmergencyData(data) {
    setId(0);
    setEmergencyDefinitionId(data.scenarioId);
    setEmergencyScenario(data.emergency_scenario);
    setActive(true);
    setMaliciousAlarm(false);
    setFalseAlarm(false);
    setEraseHelp(data.eraseHelp);
    setStartDate(data.german_date);
    setStartTime(data.german_time);
    setEndDate(data.german_date);
    setEndTime('00:00');
    setEmergencyPlace(data.emergency_place);
    setEmergencyType(data.type);
    setEmergencyDescription('');
    setEmergencyDescriptionIntern('');
    setEmergencyUnitDescription('');
    setEmergencyAlarmType(data.alarm_type);
    setEmergencyAlarmChief(true);
    setEmergencyAlarmGroup(true);
    setEmergencyAlarmFull(true);
    setEmergencyLon(data.emergency_place_lng);
    setEmergencyLat(data.emergency_place_lat);
    setNewsId(0);
    setEmergencyPressText('');
    setEmergencyPress('');
    setEmergencyVehicle(data.default_vehicles);
    setEmergencyUnits(data.stationIds);
    setIsEmergencyAlarm(data.is_alarm);
  }

  function funcDefault() {
    const d = new Date();
    setDateNow(`${d.getFullYear}-${d.getMonth()}-${d.getDate()}`);
    setTimeNow(`${d.getHours}:${d.getMinutes()}`);

    setId(0);
    setEmergencyDefinitionId(0);
    setEmergencyScenario('');
    setActive(true);
    setMaliciousAlarm(false);
    setFalseAlarm(false);
    setEraseHelp(false);
    setStartDate(getDateNow);
    setStartTime(getTimeNow);
    setEndDate(getDateNow);
    setEndTime(getTimeNow);
    setEmergencyPlace('');
    setEmergencyType(0);
    setEmergencyDescription('');
    setEmergencyDescriptionIntern('');
    setEmergencyUnitDescription('');
    setEmergencyAlarmType('einsatz');
    setEmergencyAlarmChief(true);
    setEmergencyAlarmGroup(true);
    setEmergencyAlarmFull(true);
    setEmergencyLon(0);
    setEmergencyLat(0);
    setNewsId(0);
    setEmergencyPressText('');
    setEmergencyPress('');
    setEmergencyVehicle([]);
    setEmergencyUnits([]);
    setIsEmergencyAlarm(false);
  }

  function onChangeEmergencyType(e) {
    setEmergencyType(e.value);
  }

  function onChangeAlarmEmailId(e) {
    funcDefault();
    setAlarmEmailId(e.value);
    fetch(`/api/admin/emergency/loadAlarm/${e.value}`)
      .then(response => response.json())
      .then(data => {
        setAlarmMailResponse(data.message);
        funcAlarmEmergencyData(data.message);
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

  function onChangeEmergencyAlarmType(e) {
    setEmergencyAlarmType(e.value);
  }

  function onChangeEmergencyDefinition(e) {
    setEmergencyDefinitionId(e.value);
  }

  const onChangeEmergencyUnits = data => {
    setEmergencyUnits(data);
  };

  const onChangeEmergencyVehicles = data => {
    setEmergencyVehicle(data);
  };

  const SubmitForm = event => {
    event.preventDefault();
    setErrorText(null);
    setResponseText(null);
    setLoading(true);
    const token = getCSRFToken();
    // console.log(token);
    const csrfToken = getCookie('XSRF-TOKEN');
    let headers = new Headers({
      'Content-Type': 'application/json',
    });
    if (csrfToken !== null) {
      headers = new Headers({
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
      });
    }
    console.log(getIsEmergencyAlarm);
    fetch('/api/admin/emergency/save', {
      method: 'POST',
      headers,
      body: JSON.stringify({
        'csrf-token': token,
        _token: token,
        id: getId,
        alarm_email_id: getAlarmEmailId,
        emergency_definition_id: getEmergencyDefinitionId,
        emergency_scenario: getEmergencyScenario,
        malicious_alarm: getMaliciousAlarm,
        false_alarm: getFalseAlarm,
        erase_help: getEraseHelp,
        start_date: getStartDate,
        start_time: getStartTime,
        end_date: getEndDate,
        end_time: getEndTime,
        place: getEmergencyPlace,
        type: getEmergencyType,
        withAlarm: getIsEmergencyAlarm,
        description: getEmergencyDescription,
        description_intern: getEmergencyDescriptionIntern,
        unit_description: getEmergencyUnitDescription,
        alarm_type: getEmergencyAlarmType,
        active: getActive,
        alarm_chief: getEmergencyAlarmChief,
        alarm_group: getEmergencyAlarmGroup,
        alarm_full: getEmergencyAlarmFull,
        lon: getEmergencyLon,
        lat: getEmergencyLat,
        news_id: getNewsId,
        press_text: getEmergencyPressText,
        press: getEmergencyPress,
        vehicle: getEmergencyVehicle,
        units: getEmergencyUnits,
      }),
    })
      .then(response => response.json())
      .then(data => CheckResponse(data))
      .catch(err => setCatchError(err));
  };

  useEffect(() => {
    async function fetchPreData() {
      let data_response = await fetch('/api/admin/emergency/predata');
      data_response = await data_response.json();
      setSelectValues(data_response);
      makeDefaultFireData(data_response);
    }

    async function fetchMyApi() {
      let response = await fetch(`/api/admin/emergency/data/${id}`);
      response = await response.json();
      funcEmergencyData(response);
      setLoading(false);
    }

    fetchPreData();
    if (id !== undefined) {
      setEditType('bearbeiten');
      fetchMyApi();
    } else {
      setLoading(false);
    }
  }, [id]);

  if (loading || getSelectValues === null) {
    return <LoadingAlertBox />;
  }

  return (
    <div className="container">
      <div className="overview_headline">
        <ErrorBoundary>
          <SaveInfoError responseText={responseText} errorText={errorText} />
        </ErrorBoundary>
        <ErrorBoundary>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <PageHeadline label={`Admin - Einsatz ${getEditType}`} />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Lade Alarmmail Daten:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Select
                        name="bereich"
                        defaultValue={setSelectedValue(getAlarmEmailId, getSelectValues.listalarms)}
                        options={getSelectValues.listalarms}
                        className="basic-multi-select"
                        onChange={e => onChangeAlarmEmailId(e)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <ErrorBoundary>
            <EmergencyAlarmMailMessage
              getAlarmEmailId={getAlarmEmailId}
              getAlarmMailResponse={getAlarmMailResponse}
            />
          </ErrorBoundary>
          <Row>
            <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Einsatzart:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Select
                        name="bereich"
                        value={setSelectedValue(getEmergencyType, getSelectValues.types)}
                        options={getSelectValues.types}
                        className="basic-multi-select"
                        onChange={e => onChangeEmergencyType(e)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Definition:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Select
                        name="bereich"
                        value={setSelectedValue(
                          getEmergencyDefinitionId,
                          getSelectValues.definitions
                        )}
                        options={getSelectValues.definitions}
                        className="basic-multi-select"
                        onChange={e => onChangeEmergencyDefinition(e)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Einsatztyp:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Select
                        name="einsatztyp"
                        value={setSelectedValue(
                          getEmergencyAlarmType,
                          getSelectValues.emergencytypes
                        )}
                        options={getSelectValues.emergencytypes}
                        className="basic-multi-select"
                        onChange={e => onChangeEmergencyAlarmType(e)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Einsatz Szenario:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Input
                        defaultValue={getEmergencyScenario}
                        name="emergency_scenario"
                        placeholder=""
                        className="form-control"
                        onChange={e => setEmergencyScenario(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={3} xl={3} lg={3} md={3} sm={3} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Begin Datum:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <InputDate
                        value={getStartDate}
                        name="datum"
                        placeholder=""
                        className="form-control"
                        onChange={e => setStartDate(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={3} xl={3} lg={3} md={3} sm={3} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Begin Zeit:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <InputTime
                        value={getStartTime}
                        name="time"
                        placeholder=""
                        className="form-control"
                        onChange={e => setStartTime(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={3} xl={3} lg={3} md={3} sm={3} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Ende Datum:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <InputDate
                        defaultValue={getEndDate}
                        name="datum"
                        placeholder=""
                        className="form-control"
                        onChange={e => setEndDate(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={3} xl={3} lg={3} md={3} sm={3} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Ende Zeit:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <InputTime
                        defaultValue={getEndTime}
                        name="time"
                        placeholder=""
                        className="form-control"
                        onChange={e => setEndTime(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Einsatzort:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Input
                        defaultValue={getEmergencyPlace}
                        name="emergency_place"
                        placeholder=""
                        className="form-control"
                        onChange={e => setEmergencyPlace(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          {getEmergencyLat === 0 && getEmergencyLon === 0 && getEmergencyPlace !== '' ? (
            <EmergencyGetKoorginates address={getEmergencyPlace} />
          ) : (
            <></>
          )}
          <Row>
            <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">GeoKoordinate:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Input
                        value={getEmergencyLat}
                        name="emergency_lat"
                        placeholder=""
                        className="form-control"
                        onChange={e => setEmergencyLat(e.target.value as unknown as number)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">GeoKoordinate:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Input
                        value={getEmergencyLon}
                        name="emergency_lon"
                        placeholder=""
                        className="form-control"
                        onChange={e => setEmergencyLon(e.target.value as unknown as number)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <EmergencyMap lat={getEmergencyLat} lon={getEmergencyLon} />
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">
                    Einheiten: (DRK?, Polizei?, Bundespolizei?, Bagger?, Rettungsdienst?)
                  </label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Select
                        name="units"
                        value={getEmergencyUnits}
                        options={getSelectValues.units}
                        className="basic-multi-select"
                        placeholder="Einheiten auswählen"
                        onChange={onChangeEmergencyUnits}
                        isMulti
                        isSearchable
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Einsatzfahrzeuge:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Select
                        name="units"
                        value={getEmergencyVehicle}
                        options={getSelectValues.vehicle}
                        className="basic-multi-select"
                        placeholder="Fahrzeug auswählen"
                        onChange={onChangeEmergencyVehicles}
                        isMulti
                        isSearchable
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Beschreibung:</label>
                  <div className="controls">
                    {getEmergencyDescription}
                    <ErrorBoundary>
                      <TextareaEditor
                        value={getEmergencyDescription}
                        onChange={e => setEmergencyDescription(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Beschreibung Intern:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <TextareaEditor
                        value={getEmergencyDescriptionIntern}
                        onChange={e => setEmergencyDescriptionIntern(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Beschreibung Einheiten:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <TextareaEditor
                        value={getEmergencyUnitDescription}
                        onChange={e => setEmergencyUnitDescription(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Pressetext:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <TextareaEditor
                        value={getEmergencyPressText}
                        onChange={e => setEmergencyPressText(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Herausgeber:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Input
                        defaultValue={getEmergencyPress}
                        name="emergency_press"
                        placeholder=""
                        className="form-control"
                        onChange={e => setEmergencyPress(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Löschhilfe?:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <ToggleSwitch
                        onChange={e => setEraseHelp(!getEraseHelp)}
                        value="1"
                        checked={getEraseHelp}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Sichtbar?:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <ToggleSwitch
                        checked={getActive}
                        onChange={e => setActive(!getActive)}
                        value="1"
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Wehrführeralarm?:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <ToggleSwitch
                        checked={getEmergencyAlarmChief}
                        onChange={e => setEmergencyAlarmChief(!getEmergencyAlarmChief)}
                        value="1"
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Gruppenalarm?:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <ToggleSwitch
                        checked={getEmergencyAlarmGroup}
                        onChange={e => setEmergencyAlarmGroup(!getEmergencyAlarmGroup)}
                        value="1"
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Vollalarm?:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <ToggleSwitch
                        checked={getEmergencyAlarmFull}
                        onChange={e => setEmergencyAlarmFull(!getEmergencyAlarmFull)}
                        value="1"
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Alarm:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <ToggleSwitch
                        checked={getIsEmergencyAlarm}
                        onChange={e => setIsEmergencyAlarm(!getIsEmergencyAlarm)}
                        value="1"
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Fehlalarm?:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <ToggleSwitch
                        checked={getFalseAlarm}
                        onChange={e => setFalseAlarm(!getFalseAlarm)}
                        value="1"
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={12}>
              <GridSimple className={getMaliciousAlarm ? 'red' : ''}>
                <div className="form-group">
                  <label className="form-label">Böswillige?:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <ToggleSwitch
                        checked={getMaliciousAlarm}
                        onChange={e => setMaliciousAlarm(!getMaliciousAlarm)}
                        value="1"
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <SaveLine SubmitForm={SubmitForm} backurl="/emergency/overview" />
        </ErrorBoundary>
      </div>
    </div>
  );
};
export default EmergencyActionAddEditComponent;
